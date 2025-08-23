<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Deal;
use App\Models\Communication;
use App\Models\Task;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CRMController extends Controller
{
    /**
     * Display the CRM dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get CRM statistics
        $stats = $this->getCRMStats($user->id);

        // Get recent activities
        $recentActivities = $this->getRecentActivities($user->id);

        // Get upcoming tasks
        $upcomingTasks = $this->getUpcomingTasks($user->id);

        // Get deals pipeline
        $dealsPipeline = $this->getDealsPipeline($user->id);

        return view('crm.index', compact('stats', 'recentActivities', 'upcomingTasks', 'dealsPipeline'));
    }

    /**
     * Display clients list.
     */
    public function clients(Request $request)
    {
        $user = Auth::user();

        $query = Client::where('user_id', $user->id);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('client_type', $request->type);
        }

        $clients = $query->with(['deals', 'communications'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

        return view('crm.clients.index', compact('clients'));
    }

    /**
     * Show client details.
     */
    public function showClient(Client $client)
    {
        $this->authorize('view', $client);

        $client->load(['deals', 'communications', 'tasks']);

        return view('crm.clients.show', compact('client'));
    }

    /**
     * Show client creation form.
     */
    public function createClient()
    {
        return view('crm.clients.create');
    }

    /**
     * Store new client.
     */
    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'client_type' => 'required|in:buyer,seller,both',
            'status' => 'required|in:active,inactive,prospect,lead,customer',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0|gte:budget_min',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        $client = Client::create($validated);
        $client->updateLeadScore();

        return redirect()->route('crm.clients.show', $client)
                        ->with('success', 'Client created successfully.');
    }

    /**
     * Show client edit form.
     */
    public function editClient(Client $client)
    {
        $this->authorize('update', $client);

        return view('crm.clients.edit', compact('client'));
    }

    /**
     * Update client.
     */
    public function updateClient(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'client_type' => 'required|in:buyer,seller,both',
            'status' => 'required|in:active,inactive,prospect,lead,customer',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0|gte:budget_min',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);
        $client->updateLeadScore();

        return redirect()->route('crm.clients.show', $client)
                        ->with('success', 'Client updated successfully.');
    }

    /**
     * Display deals list.
     */
    public function deals(Request $request)
    {
        $user = Auth::user();

        $query = Deal::where('user_id', $user->id)->with(['client', 'property']);

        // Apply filters
        if ($request->filled('stage')) {
            $query->where('stage', $request->stage);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $deals = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('crm.deals.index', compact('deals'));
    }

    /**
     * Show deal details.
     */
    public function showDeal(Deal $deal)
    {
        $this->authorize('view', $deal);

        $deal->load(['client', 'property', 'communications', 'tasks']);

        return view('crm.deals.show', compact('deal'));
    }

    /**
     * Show deal creation form.
     */
    public function createDeal()
    {
        $clients = Client::where('user_id', Auth::id())->get();
        $properties = Property::where('user_id', Auth::id())->get();

        return view('crm.deals.create', compact('clients', 'properties'));
    }

    /**
     * Store new deal.
     */
    public function storeDeal(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'property_id' => 'nullable|exists:properties,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:buy,sell,rent',
            'stage' => 'required|in:prospecting,qualification,proposal,negotiation,closing,closed_won,closed_lost',
            'value' => 'nullable|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'probability' => 'nullable|numeric|min:0|max:100',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        $deal = Deal::create($validated);
        $deal->updateCommission();

        return redirect()->route('crm.deals.show', $deal)
                        ->with('success', 'Deal created successfully.');
    }

    /**
     * Display tasks list.
     */
    public function tasks(Request $request)
    {
        $user = Auth::user();

        $query = Task::where('user_id', $user->id)->with(['client', 'deal', 'property']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $tasks = $query->orderBy('due_date', 'asc')->paginate(20);

        return view('crm.tasks.index', compact('tasks'));
    }

    /**
     * Store new task.
     */
    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'deal_id' => 'nullable|exists:deals,id',
            'property_id' => 'nullable|exists:properties,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:call,email,meeting,showing,follow_up,proposal,contract,closing,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        return back()->with('success', 'Task created successfully.');
    }

    /**
     * Mark task as completed.
     */
    public function completeTask(Task $task)
    {
        $this->authorize('update', $task);

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Task marked as completed.');
    }

    /**
     * Store new communication.
     */
    public function storeCommunication(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'deal_id' => 'nullable|exists:deals,id',
            'property_id' => 'nullable|exists:properties,id',
            'type' => 'required|in:email,phone,text,meeting,showing,open_house,follow_up,proposal,contract,other',
            'direction' => 'required|in:inbound,outbound',
            'subject' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'nullable|string|max:50',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['completed_at'] = $validated['status'] === 'completed' ? now() : null;

        $communication = Communication::create($validated);

        // Mark client as contacted
        $communication->client->markAsContacted();

        return back()->with('success', 'Communication logged successfully.');
    }

    /**
     * Get CRM statistics.
     */
    private function getCRMStats($userId)
    {
        return [
            'total_clients' => Client::where('user_id', $userId)->count(),
            'active_clients' => Client::where('user_id', $userId)->where('status', 'active')->count(),
            'total_deals' => Deal::where('user_id', $userId)->count(),
            'active_deals' => Deal::where('user_id', $userId)->active()->count(),
            'total_value' => Deal::where('user_id', $userId)->where('stage', 'closed_won')->sum('value'),
            'total_commission' => Deal::where('user_id', $userId)->where('stage', 'closed_won')->sum('commission_amount'),
            'pending_tasks' => Task::where('user_id', $userId)->where('status', 'pending')->count(),
            'overdue_tasks' => Task::where('user_id', $userId)->where('status', 'pending')->where('due_date', '<', now())->count(),
        ];
    }

    /**
     * Get recent activities.
     */
    private function getRecentActivities($userId)
    {
        return Communication::where('user_id', $userId)
                           ->with(['client', 'deal', 'property'])
                           ->orderBy('created_at', 'desc')
                           ->limit(10)
                           ->get();
    }

    /**
     * Get upcoming tasks.
     */
    private function getUpcomingTasks($userId)
    {
        return Task::where('user_id', $userId)
                  ->where('status', 'pending')
                  ->where('due_date', '>=', now())
                  ->with(['client', 'deal', 'property'])
                  ->orderBy('due_date', 'asc')
                  ->limit(10)
                  ->get();
    }

    /**
     * Get deals pipeline.
     */
    private function getDealsPipeline($userId)
    {
        return Deal::where('user_id', $userId)
                  ->whereNotIn('stage', ['closed_won', 'closed_lost'])
                  ->with(['client', 'property'])
                  ->orderBy('expected_close_date', 'asc')
                  ->limit(10)
                  ->get();
    }
}
