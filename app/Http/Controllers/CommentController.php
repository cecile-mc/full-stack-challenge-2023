<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Referral;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function getComments(Referral $referral)
    {
        $comments = Comment::where('referral_id', $referral->id)->get();

        return response()->json($comments);
    }
    public function addComment(Request $request)
    {
        $user = auth()->user();
        $text = $request->input('comment');
        $referral = $request->input('referral_id');
        $commentId = $request->input('commentId');

        if ($commentId) {
            $comment = Comment::find($commentId);
            if (!$comment) {
                return response()->json(['success' => false, 'message' => 'Comment not found']);
            }

            if ($comment->user_id === $user->id) {
                $comment->text = $text;
                $comment->save();

                $request->session()->flash('status', 'Comment updated successfully');
                return response()->json(['success' => true, 'message' => 'Comment updated successfully']);
            }
            return response()->json(['success' => false, 'message' => 'Unauthorized to update this comment']);
        } else {
            Comment::create([
                'referral_id' => $referral,
                'user_id' => $user->id,
                'text' => $text,
            ]);

            $request->session()->flash('status', 'Comment added successfully');
            return response()->json(['success' => true, 'message' => 'Comment added successfully']);
        }
    }
}
