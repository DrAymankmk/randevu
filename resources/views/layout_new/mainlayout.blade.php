<!DOCTYPE html>
@if(app()->getLocale() == 'en')
{{--@if (!Route::is(['layout-mini', 'layout-hidden', 'layout-hover-view', 'layout-full-width', 'layout-rtl']))--}}
<html lang="en" dir="ltr">
{{--@endif--}}
@endif

@if (Route::is(['layout-hidden']))
<html lang="en" data-layout="hidden">
@endif

@if (Route::is(['layout-hover-view']))
<html lang="en" data-layout="hoverview">
@endif

@if (Route::is(['layout-mini']))
<html lang="en" data-layout="mini">
@endif


@if(app()->getLocale() == 'ar')
<html lang="ar" dir="rtl">
@endif

@if (Route::is(['layout-full-width']))
<html lang="en" data-layout="full-width">
@endif

@include('layout_new.partials.title-meta')

@if (!Route::is(['layout-mini']))
<body>
@endif

@if (Route::is(['layout-mini']))
<body class="mini-sidebar">
@endif

    <!-- Start Main Wrapper -->
    @if(!Route::is(['login-basic', 'login-illustration', 'login-cover', 'login', 'register-basic', 'register-illustration', 'register-cover', 'forgot-password-basic', 'forgot-password-illustration', 'forgot-password-cover', 'reset-password-basic', 'reset-password-illustration', 'reset-password-cover', 'email-verification-basic', 'email-verification-illustration', 'email-verification-cover', 'success-basic', 'success-illustration', 'success-cover', 'two-step-verification-basic', 'two-step-verification-illustration', 'two-step-verification-cover', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance']))
    <div class="main-wrapper">
    @endif

    @if (Route::is(['login']))
    <div class="main-wrapper auth-bg auth-bg-custom position-relative overflow-hidden">
    @endif

    @if (Route::is(['coming-soon', 'under-maintenance']))
    <div class="main-wrapper auth-bg">
    @endif

    @if(Route::is(['login-basic', 'login-illustration', 'login-cover', 'register-basic', 'register-illustration', 'register-cover', 'forgot-password-basic', 'forgot-password-illustration', 'forgot-password-cover', 'reset-password-basic', 'reset-password-illustration', 'reset-password-cover', 'email-verification-basic', 'email-verification-illustration', 'email-verification-cover', 'success-basic', 'success-illustration', 'success-cover', 'two-step-verification-basic', 'two-step-verification-illustration', 'two-step-verification-cover', 'lock-screen', 'error-404', 'error-500']))
    <div class="main-wrapper auth-bg position-relative overflow-hidden">
    @endif

    @if (!Route::is(['login-basic', 'login-illustration', 'login-cover', 'login', 'register-basic', 'register-illustration', 'register-cover', 'forgot-password-basic', 'forgot-password-illustration', 'forgot-password-cover', 'reset-password-basic', 'reset-password-illustration', 'reset-password-cover', 'email-verification-basic', 'email-verification-illustration', 'email-verification-cover', 'success-basic', 'success-illustration', 'success-cover', 'two-step-verification-basic', 'two-step-verification-illustration', 'two-step-verification-cover', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance']))
        @include('layout_new.partials.header')

        @include('layout_new.partials.sidebar')
    @endif

        @yield('content')

{{--        @component('components.modal-popup')--}}
{{--        @endcomponent--}}

    </div>
    <!-- End Main Wrapper -->



    @include('layout_new.partials.footer-scripts')
            @if (session('success'))
                <div id="successToast" class="toast position-fixed bottom-0 end-0 m-3 bg-success-subtle" style="z-index: 9999;"
                     role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var toastEl = document.getElementById('successToast');
                        if (toastEl) {
                            var toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        }
                    });
                </script>
            @endif


            @if (session('error'))

                <div id="dangerToast" class="toast colored-toast top-0 bg-danger-subtle" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
                    <div class="toast-header bg-danger text-fixed-white">
                        <strong class="me-auto">Toast</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"><i class="fa-solid fa-xmark text-white"></i></button>
                    </div>
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var toastEl = document.getElementById('dangerToast');
                        if (toastEl) {
                            var toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        }
                    });
                </script>
    @endif

            <script>

                document.addEventListener('DOMContentLoaded', function () {
                    const deleteForm = document.getElementById('genericDeleteForm');

                    document.querySelectorAll('.delete-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const route = this.getAttribute('data-route');
                            const rowId = this.getAttribute('data-id');
                            deleteForm.setAttribute('action', route);
                            deleteForm.setAttribute('data-row-id', rowId);
                        });
                    });

                    deleteForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const rowId = this.getAttribute('data-row-id');

                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.querySelector('[name=_token]').value,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new URLSearchParams(new FormData(this))
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status) {
                                    // حذف العنصر من الصفحة
                                    document.getElementById(rowId)?.remove();

                                    // إغلاق المودال
                                    const modal = bootstrap.Modal.getInstance(document.getElementById('genericDeleteModal'));
                                    modal.hide();

                                    // تشغيل toast إذا موجود
                                    showToast(data.message); // مثلاً: "تم الحذف بنجاح"
                                } else {
                                    showToast('حدث خطأ أثناء الحذف ❌', 'danger'); // danger
                                }
                            })
                            .catch(error => {
                                console.error(error);
                                alert('حدث خطأ في الاتصال بالسيرفر ❌');
                            });
                    });
                });
            </script>

            <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

            <script>
                function showToast(message, type = 'success') {
                    const toastContainer = document.getElementById('toast-container');

                    // ✅ تأكد إن العنصر موجود
                    if (!toastContainer) {
                        console.warn('❗️لم يتم العثور على العنصر #toast-container');
                        return;
                    }

                    const id = `toast-${Date.now()}`;
                    const toastHTML = `
            <div id="${id}" class="toast align-items-center text-white bg-${type} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;

                    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
                    const toastEl = document.getElementById(id);
                    const bsToast = new bootstrap.Toast(toastEl);
                    bsToast.show();

                    // ✅ نظف العنصر بعد اختفائه
                    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
                }
            </script>


</body>
</html>
