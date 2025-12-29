document.addEventListener("DOMContentLoaded", () => {

    /* ==============================
        FAQ Accordion (يعمل بشكل صحيح)
    ============================== */
    const faqQuestions = document.querySelectorAll(".faq-question");

    faqQuestions.forEach(question => {
        question.addEventListener("click", () => {
            const answer = question.nextElementSibling;
            const sign = question.querySelector("span");

            // إغلاق أي سؤال مفتوح آخر
            faqQuestions.forEach(q => {
                if (q !== question && q.classList.contains("open")) {
                    q.classList.remove("open");
                    q.querySelector("span").textContent = "+";

                    const otherAnswer = q.nextElementSibling;
                    otherAnswer.classList.remove("show");
                    otherAnswer.style.maxHeight = null;
                }
            });

            // فتح أو إغلاق السؤال الحالي
            question.classList.toggle("open");

            if (question.classList.contains("open")) {
                sign.textContent = "-";
                answer.classList.add("show");
                answer.style.maxHeight = answer.scrollHeight + "px";
            } else {
                sign.textContent = "+";
                answer.classList.remove("show");
                answer.style.maxHeight = null;
            }
        });
    });
    /* ==============================
      * Auto Slide Services (الحركة التلقائية) - الحل النهائي المضمون
      * ============================== */

    const carousel = document.querySelector(".services-carousel");
    const cards = document.querySelectorAll(".service-card");
    const intervalTime = 2500; // 2.5 ثانية
    let autoSlideTimer;

    // العرض الكامل للبطاقة + المسافة بينها (280 + 30 = 310)
    const SCROLL_DISTANCE = 310;

    if (cards.length > 0) {

        function slideNext() {
            // التحقق إذا كان التمرير قد وصل إلى النهاية
            if (carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth - SCROLL_DISTANCE) {
                // العودة فوراً إلى البداية دون تمرير سلس (لتفادي وميض)
                carousel.scrollLeft = 0;
            } else {
                // التمرير بمقدار بطاقة واحدة
                carousel.scrollBy({
                    left: SCROLL_DISTANCE,
                    behavior: "smooth"
                });
            }
        }

        function startAutoSlide() {
            if (!autoSlideTimer) {
                autoSlideTimer = setInterval(slideNext, intervalTime);
            }
        }

        function stopAutoSlide() {
            clearInterval(autoSlideTimer);
            autoSlideTimer = null;
        }

        startAutoSlide();

        carousel.addEventListener('mouseover', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);
    }
});

/* ==============================
    Navigation Between Forms (دوال التنقل بين الزبون والمسؤول)
============================== */

function scrollToSection(id) {
    document.getElementById(id).scrollIntoView({
        behavior: "smooth",
        block: "center"
    });
}

function showLoginForm(event) {
    if (event) event.preventDefault();
    document.getElementById("userSelect").classList.add("hidden");
    document.getElementById("registerForm").classList.add("hidden");
    document.getElementById("loginForm").classList.remove("hidden");
    scrollToSection("loginForm");
}

function showRegisterForm(event) {
    if (event) event.preventDefault();
    document.getElementById("loginForm").classList.add("hidden");
    document.getElementById("userSelect").classList.add("hidden");
    document.getElementById("registerForm").classList.remove("hidden");
    scrollToSection("registerForm");
}

function showUserSelect(event) {
    if (event) event.preventDefault();
    document.getElementById("loginForm").classList.add("hidden");
    document.getElementById("registerForm").classList.add("hidden");
    document.getElementById("userSelect").classList.remove("hidden");
    scrollToSection("userSelect");
}
// فتح نافذة تسجيل الدخول
const loginLink = document.querySelector('a[href="login.html"]');
const loginModal = document.getElementById("loginModal");
const closeBtn = document.querySelector(".close-btn");

loginLink.addEventListener("click", function (e) {
    e.preventDefault();
    loginModal.style.display = "flex";
});

// إغلاق عند الضغط على ×
closeBtn.addEventListener("click", () => {
    loginModal.style.display = "none";
});

// إغلاق عند الضغط خارج المربع
window.addEventListener("click", (e) => {
    if (e.target === loginModal) {
        loginModal.style.display = "none";
    }
});
// تسجيل الخروج 
function confirmLogout() {
    let answer = confirm("هل أنت متأكد أنك تريد تسجيل الخروج؟");

    if (answer) {
        window.location = "logout.php";
    }
}

/*الروابط */
const ham = document.querySelector(".hamburger");
const menu = document.querySelector(".nav-links");

ham.addEventListener("click", () => {
    menu.classList.toggle("show");
});

document.querySelectorAll(".nav-links a").forEach(link => {
    link.addEventListener("click", () => {
        menu.classList.remove("show");
    });
});

/* الحجز */ 
// document.addEventListener('DOMContentLoaded', function () {

//     const pricePerNight = parseInt(
//         document.getElementById('priceData').dataset.price
//     );

//     const paymentRadios = document.querySelectorAll(
//         'input[name="payment_method"]'
//     );

//     paymentRadios.forEach(radio => {
//         radio.addEventListener('change', function () {
//             if (this.value === 'online') {
//                 openPaymentModal();
//             }
//         });
//     });


//     const form = document.getElementById('booking-form');
//     const checkin = document.getElementById('checkin');
//     const checkout = document.getElementById('checkout');
//     const totalSpan = document.getElementById('totalPrice');
//     const totalInp = document.getElementById('total_price_input');

//     /* ===== حساب السعر ===== */
//     function calculateTotal() {
//         if (!checkin.value || !checkout.value) return;

//         const inDate = new Date(checkin.value);
//         const outDate = new Date(checkout.value);

//         if (outDate <= inDate) {
//             totalSpan.innerText = 0;
//             totalInp.value = 0;
//             return;
//         }

//         const nights = Math.ceil((outDate - inDate) / (1000 * 60 * 60 * 24));
//         const total = nights * pricePerNight;

//         totalSpan.innerText = total;
//         totalInp.value = total;
//     }

//     checkin.addEventListener('change', calculateTotal);
//     checkout.addEventListener('change', calculateTotal);

//     /* ===== منع الإرسال المباشر في الدفع الإلكتروني ===== */
//     form.addEventListener('submit', function (e) {

//         const total = parseInt(totalInp.value || 0);
//         const payment = document.querySelector('input[name="payment_method"]:checked');

//         if (!payment) {
//             alert('يرجى اختيار طريقة الدفع');
//             e.preventDefault();
//             return;
//         }

//         if (total <= 0) {
//             alert('يرجى اختيار تاريخ صحيح');
//             e.preventDefault();
//             return;
//         }

//         if (payment.value === 'online') {
//             e.preventDefault();
//             openPaymentModal();
//         }
//     });

// });

// /* ===== MODAL FUNCTIONS ===== */

// function openPaymentModal() {
//     document.getElementById('paymentModal').style.display = 'flex';
// }

// function closePaymentModal() {
//     document.getElementById('paymentModal').style.display = 'none';
// }

// function confirmOnlinePayment() {
//     closePaymentModal();
//     document.getElementById('booking-form').submit();
// }

// function closeConflictModal() {
//     const modal = document.getElementById('conflictModal');
//     if (modal) modal.style.display = 'none';
// }




