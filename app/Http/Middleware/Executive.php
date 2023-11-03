<?php

namespace App\Http\Middleware;

use Closure;

class Executive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->status) {
            $request->session()->flash('error', 'Please contact the administrator to activate your account');
            return redirect('blocked')->with('error', "You do not have access to that page!.");
        } elseif ($request->user()->role === 'executive') {
            return $next($request);
        }
        $request->session()->flash('error', 'You do not have access to that page!');
        return redirect()->back()->with('error', "You do not have access to that page!.");
    }
}
