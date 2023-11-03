@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Referrals</h1>
                </div>

                <div class="panel-body">
                    <div>@include('partials.filterReferrals') @include('partials.createReferralButton') @include('partials.searchReferrals')
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        @if($referrals->isEmpty())
                        <p>No referrals found.</p>
                        @else
                        <table id="referrals-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Comments</th>
                                    <th>Country</th>
                                    <th>Reference No</th>
                                    <th>Organisation</th>
                                    <th>Province</th>
                                    <th>District</th>
                                    <th>City</th>
                                    <th>Street Address</th>
                                    <th>Gps Location</th>
                                    <th>Facility Name</th>
                                    <th>Facility Type</th>
                                    <th>Provider Name</th>
                                    <th>Position</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Website</th>
                                    <th>Pills Available</th>
                                    <th>Code To Use</th>
                                    <th>Type of Service</th>
                                    <th>Note</th>
                                    <th>Womens Evaluation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referrals as $referral)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="glyphicon glyphicon-comment open-modal" data-toggle="modal" data-target="#commentModal{{ $referral->id }}" data-url="{{ $referral->id }}"></span>
                                    </td>

                                    <td>{{ $referral->country }} </td>
                                    <td>{{ $referral->reference_no }} </td>
                                    <td>{{ $referral->organisation }} </td>
                                    <td>{{ $referral->province }} </td>
                                    <td>{{ $referral->district }} </td>
                                    <td>{{ $referral->city }} </td>
                                    <td>{{ decrypt($referral->street_address) }} </td>
                                    <td>{{ decrypt($referral->gps_location) }} </td>
                                    <td>{{ $referral->facility_name }} </td>
                                    <td>{{ $referral->facility_type }} </td>
                                    <td>{{ $referral->provider_name }} </td>
                                    <td>{{ $referral->position }} </td>
                                    <td>{{ decrypt($referral->phone) }} </td>
                                    <td>{{ decrypt($referral->email) }} </td>
                                    <td>{{ $referral->website }} </td>
                                    <td>{{ $referral->pills_available }} </td>
                                    <td>{{ $referral->code_to_use }} </td>
                                    <td>{{ $referral->type_of_service }} </td>
                                    <td>{{ $referral->note }} </td>
                                    <td>{{ $referral->womens_evaluation }} </td>
                                </tr>
                                <div class="modal fade" id="commentModal{{ $referral->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="commentModalLabel">Comments for Referral ID: {{ $referral->id }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    @foreach($comments as $comment)
                                                    @if($comment->referral_id !== $referral->id)
                                                    @continue
                                                    @else
                                                    <div class="comment">
                                                        <div class="comment-header">
                                                            <span class="comment-author">{{ $comment->user ? $comment->user->name : 'Anonymous' }}</span>
                                                            <span class="comment-date">{{ $comment->updated_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="comment-body">
                                                            <p>{{ $comment->text }}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                    <div class="comment-form" id="comment-form-{{ $referral->id }}" data-referral-id="{{ $referral->id }}">
                                                        <input type="hidden" name="referral_id" value="{{ $referral->id }}">
                                                        <input type="hidden" name="commentId" id="commentId-{{ $referral->id }}" value="{{ $referral->comments->where('user_id', auth()->id())->first()->id ?? '' }}">
                                                        <div class="form-group">
                                                            <label for="commentInput">Comments: </label>
                                                            <input name="text" id="commentInput" class="form" placeholder="Add a comment" value="{{ $referral->comments->where('user_id', auth()->id())->first()->text ?? '' }}">
                                                        </div>
                                                        @if(auth()->check() && $referral->comments->where('user_id', auth()->id())->isEmpty())
                                                        <button class="submit-comment-button btn btn-success" data-referral-id="{{ $referral->id }}">Save</button>
                                                        @else
                                                        <button class="submit-comment-button btn btn-primary" data-referral-id="{{ $referral->id }}">Update</button>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>

                <div class="panel-footer">
                    {{ $referrals->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection