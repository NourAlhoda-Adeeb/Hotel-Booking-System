<?= view('layout/header', ['title' => 'الرئيسية']) ?>

<!-- HERO SECTION -->
<div class="hero-wrapper" id="hero">
    <div class="bg-blur"></div>
    <div class="hero-card">
        <img src="<?= base_url('images/profile.jpg') ?>">
    </div>
</div>

<!-- SERVICES -->
<section class="services-section" id="services">
    <h2 class="section-title">الخدمات التي نقوم بتقديمها</h2>
    <p class="section-subtitle">يمكنك تسجيل الدخول والاستفادة منها</p>

    <div class="services-carousel">

        <a href="<?= base_url('about') ?>" class="service-card">
            <img src="<?= base_url('images/service.jpeg') ?>">
            <h3>معلومات حول الفندق</h3>
            <p>اطلع علي معلومات عنا</p>
        </a>

        <a href="<?= base_url('rooms') ?>" class="service-card">
            <img src="<?= base_url('images/service1.jpeg') ?>">
            <h3>الغرف</h3>
            <p>إطلع على كافة الغرف الموجودة في الفندق.</p>
        </a>

        <a href="<?= base_url('services') ?>" class="service-card">
            <img src="<?= base_url('images/service2.jpeg') ?>">
            <h3>الخدمات المتوفرة</h3>
            <p>اطّلع على كافة الخدمات المتوفرة في الفندق.</p>
        </a>

    </div>
</section>

<!-- FAQ -->
<section class="faq-section" id="faq">
        <h2 class="section-title">أسئلة شائعة</h2>

        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question"><span>+</span> كيف أتواصل قبل الحجز؟</div>
                <div class="faq-answer">
                    <p>يمكنك التواصل مباشرة مع مزود الخدمة .</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question"><span>+</span> هل توجد خدمات إضافية ؟</div>
                <div class="faq-answer">
                    <p>نعم، يمكنك الاطلاع علي كافة خدماتنا المتوفرة .</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question"><span>+</span> ما طرق الدفع المتاحة؟</div>
                <div class="faq-answer">
                    <p>نوفر الدفع الإلكتروني والنقدي .</p>
                </div>
            </div>
        </div>
    </section>

<!-- CONTACT -->
<section class="contact-section" id="contact">
        <div class="contact-container">

            <div class="contact-map">
                <h2>موقعنا على الخريطة</h2>
                <div class="map-placeholder">
                    <iframe src="https://maps.google.com/maps?q=tripoli%20libya&t=&z=13&ie=UTF8&iwloc=&output=embed">
                    </iframe>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <h2>تواصل معنا</h2>
                <form class="contact-form">
                    <input type="text" placeholder="الاسم">
                    <input type="email" placeholder="البريد الإلكتروني">
                    <textarea placeholder="رسالتك"></textarea>
                    <button class="submit-button">إرسال</button>
                </form>
            </div>

        </div>
    </section>

<?= view('layout/footer') ?>
