<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{

    public function index(request $request,tickets $tickets)
    {
        
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('tech')) {
            $tickets = Tickets::all();
        } else {
            $tickets = Tickets::where('user_id', Auth::id())->get();
        }

       return view('tickets.index', compact('tickets'));

    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:500',
            'about' => 'required|string',
            'priority' => 'required|integer|in:1,2,3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($request->hasFile('image')) {
            $tickets->image = $request->file('image')->store('tickets', 'public');
        }

        Tickets::create([
            'title' => $request->title,
            'about' => $request->about,
            'status' => 0,
            'user_id' => Auth::id(),
            'priority' => $request->priority,
        ]);

        return redirect()->route('tickets.index')->with('status', 'Ticket submited');

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id, tickets $tickets)
    {
        $tickets = Tickets::find($id);
        return view('tickets.show', compact('tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, tickets $tickets)
    {
        $tickets = Tickets::find($id);
        return view('tickets.edit', compact('tickets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tickets = Tickets::find($id);
        $request->validate([
            'title' => 'required|string|max:500',
            'about' => 'required|string',

            'priority' => 'required|integer|min:1|max:3',
        ]);

        $tickets->update($request->all());
        return redirect()->route('tickets.index')->with('success','Ticket has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tickets = Tickets::find($id);

        $tickets->delete();
        return redirect()->route('tickets.index')->with('success','Ticket has been deleted');
    }

    public function markComplete(Tickets $ticket)
    {
        if ($ticket->status == 0) {
            $ticket->status = 1;
            $ticket->save();
        }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket marked as complete.');
    }
}
