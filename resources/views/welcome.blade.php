<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mr Fix - تطبيق العمالة الماهرة</title>
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --light-color: #ecf0f1;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9f9f9;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), #3498db);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            opacity: 0.2;
        }

        .app-features i {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .feature-card {
            border-radius: 10px;
            transition: transform 0.3s;
            height: 100%;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .download-section {
            background-color: #6f0207;
            color: white;
            padding: 80px 0;
        }

        .app-btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: bold;
            margin: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .app-btn i {
            margin-left: 8px;
        }

        .app-btn-primary {
            background-color: #2678B0;
            color: white;
        }

        .app-btn-primary:hover {
            background-color: #c0392b;
            color: white;
            transform: translateY(-3px);
        }

        .app-btn-outline {
            border: 2px solid white;
            color: white;
        }

        .app-btn-outline:hover {
            background-color: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .how-it-works {
            padding: 80px 0;
            background-color: var(--light-color);
        }

        .step-number {
            width: 50px;
            height: 50px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 auto 15px;
        }

        .testimonials {
            padding: 80px 0;
        }

        .testimonial-card {
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 10px;
            height: 100%;
        }

        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 15px;
            border: 3px solid var(--secondary-color);
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 40px 0 20px;
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
            transform: translateY(-3px);
        }

        .search-box {
            background-color: white;
            border-radius: 50px;
            padding: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .search-input {
            border: none;
            outline: none;
            width: 70%;
            padding: 10px 15px;
        }

        .search-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: bold;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
        }

        .navbar-brand span {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Mr<span>Fix</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">المميزات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">كيف يعمل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#download">حمل التطبيق</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">آراء العملاء</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="#download" class="btn btn-outline-light me-2">حمل التطبيق</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container position-relative">
            <div class="row align-items-center text-start">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">ابحث عن أفضل العمالة الماهرة في منطقتك</h1>
                    <p class="lead mb-5">Mr Fix يوفر لك الحل الأمثل لإيجاد فنيين محترفين في جميع المجالات بسرعة وسهولة</p>

                    <div class="d-flex justify-content-start">
                        <a href="#" class="app-btn app-btn-primary">
                            <i class="fas fa-download"></i> حمل التطبيق
                        </a>
                        <a href="#" class="app-btn app-btn-outline">
                            <i class="fas fa-play-circle"></i> شاهد الفيديو
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('assets/img/screenmrfix.png') }}" alt="Mr Fix App Screenshot" class="img-fluid" style="width: 300px">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="app-features py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">لماذا تختار Mr Fix؟</h2>
                <p class="text-muted">نقدم لك أفضل الحلول لإيجاد العمالة الماهرة بكل سهولة</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-bolt"></i>
                        <h4>خدمة سريعة</h4>
                        <p>ابحث وحدد الفني المناسب في دقائق معدودة دون عناء أو ضياع للوقت</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-star"></i>
                        <h4>فنيون محترفون</h4>
                        <p>فنيون معتمدون وذوو خبرة عالية مع تقييمات حقيقية من العملاء</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-shield-alt"></i>
                        <h4>ضمان الجودة</h4>
                        <p>ضمان على جميع الخدمات المقدمة مع إمكانية إعادة الخدمة في حال عدم الرضا</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-money-bill-wave"></i>
                        <h4>أسعار مناسبة</h4>
                        <p>أسعار تنافسية مع إمكانية المقارنة بين عروض الفنيين المختلفة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>خدمة في جميع المناطق</h4>
                        <p>غطاء واسع يشمل جميع المناطق مع إمكانية تحديد الفنيين الأقرب إليك</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-headset"></i>
                        <h4>دعم فني 24/7</h4>
                        <p>فريق دعم فني متاح على مدار الساعة لمساعدتك في أي استفسار أو مشكلة</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">كيف يعمل التطبيق؟</h2>
                <p class="text-muted">3 خطوات بسيطة للحصول على الخدمة المطلوبة</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="step-number">1</div>
                    <h4>ابحث عن الخدمة</h4>
                    <p>حدد نوع الخدمة التي تحتاجها وموقعك الجغرافي</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="step-number">2</div>
                    <h4>اختر الفني المناسب</h4>
                    <p>قارن بين الفنيين المتاحين بناء على التقييمات والأسعار</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="step-number">3</div>
                    <h4>احصل على الخدمة</h4>
                    <p>حدد موعد الخدمة وتابع وصول الفني عبر التطبيق</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="download-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-4">حمل تطبيق Mr Fix الآن</h2>
                    <p class="mb-4">احصل على أفضل تجربة مع تطبيقنا المخصص للهواتف الذكية. تصفح الفنيين، احجز الخدمات، تابع الحجوزات، وقيم الخدمات كلها في مكان واحد.</p>

                    <div class="d-flex flex-wrap justify-content-start">
                        <a href="#" class="app-btn app-btn-primary me-3 mb-3">
                            <i class="fab fa-google-play"></i> Google Play
                        </a>
                        <a href="#" class="app-btn app-btn-primary mb-3">
                            <i class="fab fa-apple"></i> App Store
                        </a>
                    </div>

                    <div class="mt-4">
                        <p>أو استخدم الرابط المباشر:</p>
                        <div class="input-group mb-3" style="max-width: 400px;">
                            <input type="text" class="form-control" value="https://mrfix.com/download" readonly>
                            <button class="btn btn-danger" type="button">نسخ</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://via.placeholder.com/500x500" alt="Mobile App" class="img-fluid" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">آراء عملائنا</h2>
                <p class="text-muted">ما يقوله عملاؤنا عن تجربتهم مع Mr Fix</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card text-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="testimonial-img">
                        <h5>أحمد محمد</h5>
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"وفرت علي الكثير من الوقت والجهد في إيجاد فني تكييف محترف. الخدمة كانت ممتازة والسعر معقول."</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card text-center">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="testimonial-img">
                        <h5>سارة عبدالله</h5>
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p>"استخدمت التطبيق لإصلاح تسريب المياه في منزلي، الفني وصل في الوقت المحدد وكان عمله متقناً. شكراً لكم."</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card text-center">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Client" class="testimonial-img">
                        <h5>خالد علي</h5>
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"أفضل تطبيق للخدمات المنزلية. سهولة الاستخدام وجودة الفنيين جعلتني أعتمد عليه في جميع احتياجاتي."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">الأسئلة الشائعة</h2>
                <p class="text-muted">إجابات على أكثر الأسئلة شيوعاً</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    كيف يمكنني الدفع مقابل الخدمة؟
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    يمكنك الدفع نقداً للفني مباشرة بعد انتهاء الخدمة، أو عبر التطبيق باستخدام بطاقات الائتمان أو المحافظ الإلكترونية.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    هل يمكنني إلغاء الحجز بعد التأكيد؟
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    نعم، يمكنك إلغاء الحجز قبل 24 ساعة من موعد الخدمة دون أي رسوم. للإلغاء بعد ذلك، قد تطبق بعض الرسوم حسب سياسة الفني.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    كيف يتم اختيار الفنيين في التطبيق؟
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    جميع الفنيين في التطبيق يخضعون لعمليات فحص واعتماد دقيقة تشمل التحقق من المؤهلات والخبرات والتقييمات السابقة. نحرص على تقديم فنيين محترفين وذوي كفاءة عالية.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="mb-4">MrFix</h4>
                    <p>منصة رائدة في مجال ربط العملاء بالعمالة الماهرة في مختلف المجالات. نسعى لتقديم أفضل تجربة للمستخدمين مع ضمان الجودة والكفاءة.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="mb-4">روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">الرئيسية</a></li>
                        <li class="mb-2"><a href="#features" class="text-white text-decoration-none">المميزات</a></li>
                        <li class="mb-2"><a href="#how-it-works" class="text-white text-decoration-none">كيف يعمل</a></li>
                        <li class="mb-2"><a href="#download" class="text-white text-decoration-none">حمل التطبيق</a></li>
                        <li class="mb-2"><a href="#testimonials" class="text-white text-decoration-none">آراء العملاء</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="mb-4">خدماتنا</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">سباكة</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">كهرباء</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">تكييف وتبريد</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">نجارة</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">دهان وديكور</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="mb-4">اتصل بنا</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-2"></i> الرياض، المملكة العربية السعودية</li>
                        <li class="mb-3"><i class="fas fa-phone me-2"></i> +966 12 345 6789</li>
                        <li class="mb-3"><i class="fas fa-envelope me-2"></i> info@mrfix.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2023 MrFix. جميع الحقوق محفوظة.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">شروط الخدمة</a>
                    <a href="#" class="text-white text-decoration-none">سياسة الخصوصية</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy link function
        document.querySelector('.btn-danger').addEventListener('click', function() {
            const copyText = document.querySelector('input[type="text"]');
            copyText.select();
            document.execCommand('copy');

            const originalText = this.textContent;
            this.textContent = 'تم النسخ!';

            setTimeout(() => {
                this.textContent = originalText;
            }, 2000);
        });
    </script>
</body>
</html>
