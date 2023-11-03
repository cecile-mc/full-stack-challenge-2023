<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Referral Database') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>

<body>
    <div id=" app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Referral Database') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    @if(Auth::user()->status)
                                    <a href="{{ route('add-referral') }}">
                                        Add Referral
                                    </a>
                                    @endif
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#filter").click(function() {
                var country = $("#country").val();
                if (country == undefined) {
                    country = $("#city").val();
                }
                var divider = window.location.href.substr(-1) == '/' ? '' : '/'
                window.location.href = window.location.origin + window.location.pathname + divider + country;

            });
        });

        $(document).ready(function() {
            $('#search-table').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                $('#referrals-table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });
        });

        function confirmAction(action) {
            return window.confirm(`Are you sure you want to ${action} this user?`);
        }

        document.querySelectorAll('.confirm-action-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const action = this.getAttribute('data-action');
                const form = this.closest('form');

                if (confirmAction(action)) {
                    form.submit();
                } else {
                    e.preventDefault();
                }
            });
        });

        $(document).on('click', '.open-modal', function() {
            var url = $(this).data('url');
            $('#commentModal .modal-body').load(url, function() {
                $('#commentModal').modal('show');
            });
        });


        $(document).ready(function() {
            $('.submit-comment-button').on('click', function() {
                var referral_id = $(this).data('referral-id');
                var commentText = $('#comment-form-' + referral_id + ' input[name="text"]').val();
                var commentId = $('#comment-form-' + referral_id + ' input[name="commentId"]').val();

                if (commentText.trim() !== '') {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('addComment') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            referral_id: referral_id,
                            comment: commentText,
                            commentId: commentId,
                        },
                        success: function(data) {
                            $('#commentModal' + referral_id).modal('hide');
                            location.reload();
                        },
                        error: function(error) {
                            alert(error.responseJSON.message);
                        }
                    });
                } else {
                    alert('Please enter a comment before submitting.');
                }
            });
        });

        const editCommentButtons = document.querySelectorAll('#edit-comment-button');

        for (const editCommentButton of editCommentButtons) {
            editCommentButton.addEventListener('click', () => {
                const commentForm = editCommentButton.closest('.modal-content').querySelector('.comment-form');
                commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
            });
        }
    </script>

    <style>
        .comment-form {
            display: block;
        }
    </style>
</body>

</html>