# Zx helper version 1.3.0
helper untuk melindungi website mu

## penggunaan:
> tempatkan file ini pada root home,<br>
> lalu get pada file yang mau di lindungi dengan syntax `require('helper.php');`<br>
> panggil method nya sesuai kebutuhan `security::methodnya();`<br>
> CONTOH :`security::redirect('http://google.com');`
## features
- secure uploaded `security::filter_upload();`
- secure CSRF `security::lock_csrf(available input);`
- secure comment user `security::comment(available input);`
- configurasi database dengan mudah
- support driver `MYSQLI` and `PDO`
- melindungi parameter ID anti `SQLI`
- melindungi parameter string anti `bypass blind SQLI`
- melindungi form login anti bypass `SQL Login`
- melindungi input, output anti `XSS, JSO`
- penulisan Query SQL dengan mudah
- redirect halaman
- and more
