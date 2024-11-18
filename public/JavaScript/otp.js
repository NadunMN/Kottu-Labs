const inputs = document.querySelectorAll('.otp-field input');
        const verifyButton = document.getElementById('verifyButton');

        function checkAllFieldsFilled() {
            return Array.from(inputs).every(input => input.value.trim() !== '');
        }

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length > 1) {
                    input.value = input.value.slice(0, 1);
                }

                if (input.value !== '' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                verifyButton.disabled = !checkAllFieldsFilled();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && input.value === '') {
                    inputs[index - 1].focus();
                }
            });
        });

        // Timer
        let timeLeft = 90;
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            countdownEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft === 0) {
                clearInterval(timer);
                countdownEl.textContent = '0:00';
            }

            timeLeft--;
        }, 1000);

        // Form submission
        document.getElementById('otpForm').addEventListener('submit', (e) => {
            e.preventDefault();

            if (checkAllFieldsFilled()) {
                alert('OTP Verified!');
            } else {
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('error');
                    } else {
                        input.classList.remove('error');
                    }
                });
            }
        });