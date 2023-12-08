<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ResetPassController extends Controller
{
    //
    public function show_reset()
    {
        return view('pages.emails.resetpass');
    }

    public function activereset(Request $request)
    {
        $email = $request->input('email');
        $user = DB::table('user')->where('email', $email)->first();
        if (!$user) {
            // Nếu email không tồn tại, chuyển hướng người dùng và cung cấp thông báo
            return Redirect::to('/resetpass')->with('message', 'Email không tồn tại, vui lòng kiểm tra lại.');
        }

        if ($user && $user->token) {

            //tồn tại token thì k thực hiện

            return Redirect::to('/login')->with('message', 'Bạn đã yêu cầu reset mật khẩu. Vui lòng kiểm tra email của bạn.');
        }

        $token = Str::random(60);
        $token_time = Carbon::now('Asia/Ho_Chi_Minh'); // thời điểm hiện tại
        DB::table('user')
            ->where('email', $email)
            ->update([
                'token' => $token,
                'token_time' => $token_time,
            ]);
        $link = "<a href='http://192.168.1.161:80/bookstoreweb/reset_pass.php?key=" . $email . "&token=" . $token . "'>Đặt lại mật khẩu</a>";

        // Tạo một PHPMailer instance
        $mailer = new PHPMailer(true);

        // Cấu hình thông tin email
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'hakcheck3@gmail.com';
        $mailer->Password = 'ltmdgmngfmakshhl';
        $mailer->SMTPSecure = 'ssl';
        $mailer->Port = 465;
        $mailer->setFrom('hakcheck3@gmail.com', 'BookStore');
        $mailer->addAddress($email);
        $mailer->Subject = 'Book Store Reset Pass';
        $mailer->Body = "Nhấn vào liên kết sau để đặt lại mật khẩu: " .$link;
        // Gửi email
        if ($mailer->send()) {
            return Redirect::to('/login')->with('message', 'Bạn đã yêu cầu reset mật khẩu. Vui lòng kiểm tra email của bạn.');

        } else {
            return Redirect::to('/resetpass')->with('message', 'Có lỗi trong quá trình gửi email. Vui lòng thử lại sau.');
        }
        // Trả về thông báo cho người dùng
    }
}


