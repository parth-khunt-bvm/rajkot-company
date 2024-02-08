<!DOCTYPE html>
<html lang="en">
    @include('backend.pdf.include.header')
    <body class="invoice-box">
        <div class="invoice-box">
            <main>
                @yield('section')

            </main>

            @include('backend.pdf.include.footer')
        </div>
  </body>
</html>
