<script>
    document.getElementById('adminloginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('responseMessage');

                if (data.success) {
                    responseMessage.style.color = 'green';
                    responseMessage.textContent = data.message;

                    // Redirect after successful login
                    setTimeout(() => window.location.href = "{{ route('returnHome') }}", 2000);
                } else {
                    responseMessage.style.color = 'red';
                    responseMessage.textContent = data.message;
                }

                responseMessage.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('responseMessage');

                if (data.success) {
                    responseMessage.style.color = 'green';
                    responseMessage.textContent = data.message;

                    // Redirect after successful login
                    setTimeout(() => window.location.href = "{{ route('returnHome') }}", 2000);
                } else {
                    responseMessage.style.color = 'red';
                    responseMessage.textContent = data.message;
                }

                responseMessage.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>

{{-- <script>
    // Load Facebook SDK
    window.fbAsyncInit = function() {
        FB.init({
            appId: '3880290302185411', // Replace with your Facebook App ID
            cookie: true,
            xfbml: true,
            version: 'v16.0' // Facebook API version
        });

        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Handle Custom Facebook Login
    document.getElementById('customFacebookLogin').addEventListener('click', function() {
        FB.login(function(response) {
            if (response.authResponse) {
                // Fetch user details
                FB.api('/me', {
                    fields: 'id,name,email'
                }, function(userResponse) {
                    if (!userResponse.email) {
                        alert('Email permission is required for login.');
                        return;
                    }

                    // Send user data to Laravel backend
                    $.ajax({
                        url: '/facebook-login',
                        type: 'POST',
                        data: {
                            facebook_login: true,
                            id: userResponse.id,
                            name: userResponse.name,
                            email: userResponse.email,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Redirect to desired location
                                window.location.href = response.redirect_url;
                            } else {
                                alert('Login failed! ' + (response.message || 'Unknown error.'));
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred during Facebook Login: ' + error);
                        }
                    });
                });
            } else {
                alert('User cancelled login or did not fully authorize.');
            }
        }, {
            scope: 'email'
        }); // Request email permission
    });
</script> --}}



{{-- 
<script>
    document.getElementById('register_form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('responseMessage');

                if (data.success) {
                    responseMessage.style.color = 'green';
                    responseMessage.textContent = data.message;

                    // Redirect after successful login
                    setTimeout(() => window.location.href = "{{ route('returnHome') }}", 2000);
                } else {
                    responseMessage.style.color = 'red';
                    responseMessage.textContent = data.message;
                }

                responseMessage.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script> --}}
