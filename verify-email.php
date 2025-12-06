<?php
$pageTitle = 'Verify Email';
include __DIR__ . '/includes/head.php';
?>

<div class="flex min-h-screen w-full flex-col bg-muted/20">
    <div class="flex flex-col items-center justify-center min-h-[80vh] px-4">
        
        <div class="glass-card w-full max-w-md p-8 space-y-6 fade-up">
            <div class="flex flex-col items-center text-center space-y-2">
                <div class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-2">
                    <i data-lucide="mail-check" class="h-6 w-6"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Verify Your Email</h1>
                <p class="text-sm text-muted-foreground">
                    We sent a 6-digit code to <span id="userEmail" class="font-medium text-foreground">your email</span>.
                    Enter it below to verify your account.
                </p>
            </div>

            <form id="verifyForm" class="space-y-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="otp">
                        One-Time Password
                    </label>
                    <div class="flex justify-center gap-2" id="otpContainer">
                        <!-- 6 inputs for OTP -->
                        <input type="text" maxlength="1" class="otp-input flex h-12 w-10 items-center justify-center rounded-md border border-input bg-background/50 text-center text-lg font-bold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" autofocus />
                        <input type="text" maxlength="1" class="otp-input flex h-12 w-10 items-center justify-center rounded-md border border-input bg-background/50 text-center text-lg font-bold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        <input type="text" maxlength="1" class="otp-input flex h-12 w-10 items-center justify-center rounded-md border border-input bg-background/50 text-center text-lg font-bold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        <input type="text" maxlength="1" class="otp-input flex h-12 w-10 items-center justify-center rounded-md border border-input bg-background/50 text-center text-lg font-bold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        <input type="text" maxlength="1" class="otp-input flex h-12 w-10 items-center justify-center rounded-md border border-input bg-background/50 text-center text-lg font-bold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        <input type="text" maxlength="1" class="otp-input flex h-12 w-10 items-center justify-center rounded-md border border-input bg-background/50 text-center text-lg font-bold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                    </div>
                </div>

                <button type="submit" id="verifyBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                    <span id="btnText">Verify Account</span>
                    <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                </button>
            </form>

            <div class="text-center text-sm">
                <p class="text-muted-foreground">
                    Didn't receive the code? 
                    <button id="resendBtn" type="button" class="font-medium text-primary underline-offset-4 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        Resend OTP
                    </button>
                    <span id="countdown" class="hidden ml-1 text-muted-foreground">(60s)</span>
                </p>
            </div>
            
             <div class="text-center text-sm mt-4">
                <a href="/login" class="text-muted-foreground hover:text-foreground">Back to Login</a>
            </div>
        </div>
    </div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

<script src="/assets/js/config.js"></script>
<script src="/assets/js/api.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    lucide.createIcons();
    
    document.addEventListener('DOMContentLoaded', async () => {
        // Init GSAP
        gsap.to(".fade-up", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });

        // Auto-focus first input
        const inputs = document.querySelectorAll('.otp-input');
        if(inputs.length > 0) inputs[0].focus();

        // Get Current User Email or URL Email
        let userEmail = '';
        let isAuthenticated = false;

        const urlParams = new URLSearchParams(window.location.search);
        const urlEmail = urlParams.get('email');

        try {
            const user = await AuthService.fetchCurrentUser(true); 
            if (user) {
                userEmail = user.email;
                isAuthenticated = true;
                
                if (user.isEmailVerified) {
                    showToast('Email already verified!', 'success');
                    setTimeout(() => window.location.href = '/user/', 1500);
                    return;
                }
            }
        } catch (e) {
            console.log("Not authenticated, checking URL params");
        }

        if (!userEmail && urlEmail) {
            userEmail = urlEmail;
        }

        if (!userEmail) {
            // No email found from auth or URL -> Redirect to login
            window.location.href = '/login';
            return;
        }

        document.getElementById('userEmail').textContent = userEmail;

        // OTP Input Logic
        const form = document.getElementById('verifyForm');
        
        inputs.forEach((input, index) => {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1); // Enforce max length
                }
                
                if (e.target.value) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    } else {
                        // Last digit filled? Auto-submit
                        const otp = Array.from(inputs).map(i => i.value).join('');
                        if (otp.length === 6) {
                            handleVerify(otp);
                        }
                    }
                }
            });
            
            // Allow pasting full OTP
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').slice(0, 6).split('');
                if (pastedData.length > 0) {
                   inputs.forEach((inp, idx) => {
                       if (idx < pastedData.length) {
                           inp.value = pastedData[idx];
                       }
                   });
                   const nextIdx = Math.min(pastedData.length, inputs.length - 1);
                   inputs[nextIdx].focus();
                   
                   const otp = Array.from(inputs).map(i => i.value).join('');
                   if (otp.length === 6) {
                        handleVerify(otp);
                   }
                }
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const otp = Array.from(inputs).map(i => i.value).join('');
            if (otp.length !== 6) {
                showToast('Please enter a complete 6-digit code', 'error');
                return;
            }
            handleVerify(otp);
        });

        async function handleVerify(otp) {
            const btn = document.getElementById('verifyBtn');
            const btnText = document.getElementById('btnText');
            
            // Disable inputs/button
            inputs.forEach(i => i.disabled = true);
            btn.disabled = true;
            btnText.textContent = 'Verifying...';
            
            try {
                await AuthService.verifyEmail(userEmail, otp);
                showToast('Email verified successfully!', 'success');
                setTimeout(() => {
                    if (isAuthenticated) {
                        window.location.href = '/user/';
                    } else {
                        // If not logged in, redirect to login page
                        window.location.href = '/login?verified=true';
                    }
                }, 1500);
            } catch (error) {
                showToast(error.message || 'Verification failed. Please try again.', 'error');
                // Re-enable
                inputs.forEach(i => { i.disabled = false; i.value = ''; });
                inputs[0].focus();
                btn.disabled = false;
                btnText.textContent = 'Verify Account';
            }
        }

        // Resend OTP Logic
        const resendBtn = document.getElementById('resendBtn');
        const countdownEl = document.getElementById('countdown');
        let canResend = true;

        resendBtn.addEventListener('click', async () => {
            if (!canResend) return;
            
            try {
                resendBtn.disabled = true;
                await AuthService.resendOtp(userEmail);
                showToast('OTP code resent successfully', 'success');
                
                // Start countdown
                canResend = false;
                let timeLeft = 60;
                resendBtn.classList.add('hidden');
                countdownEl.classList.remove('hidden');
                countdownEl.textContent = `(${timeLeft}s)`;
                
                const timer = setInterval(() => {
                    timeLeft--;
                    countdownEl.textContent = `(${timeLeft}s)`;
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        canResend = true;
                        resendBtn.disabled = false;
                        resendBtn.classList.remove('hidden');
                        countdownEl.classList.add('hidden');
                    }
                }, 1000);

            } catch (error) {
                showToast(error.message || 'Failed to resend OTP', 'error');
                resendBtn.disabled = false;
            }
        });
    });
</script>
</body>
</html>
