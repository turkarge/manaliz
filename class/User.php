<?php
class User extends DB
{
    public static $userID = NULL;
    public static $getUser = false;

    public static function login($mailOrNickName, $password, $remember = 0)
    {
        $result = self::table("users")
            ->whereRaw("userNickName=? OR userMail=?", [$mailOrNickName, $mailOrNickName])
            ->where(["userPassword" => md5($password), "status" => 1])
            ->first();
        if ($result) {
            self::$getUser = $result;
            self::$userID = $result->ID;
            $_SESSION["mu_user"] = $result;
            if ($remember == 1) {
                setcookie("mu_user_cookie", $result, time() + (48 * 60 * 60));
            }
            return true;
        } else {
            return false;
        }
    }
    public static function forgotPassword($mail, $siteUrl)
    {
        $result = self::table("users")->where(["userMail" => $mail, "status" => 1])->first();
        if ($result) {
            $token = uniqid();
            $passwordTokenAdd = self::table("password_tokens")->updateOrCreate(
                ["userID" => $result->ID],
                [
                    "userID" => $result->ID,
                    "token" => $token
                ]
            );
            if ($passwordTokenAdd) {
                $message = '<p>Sayın <strong>' . $result->userNameSurname . '</strong></p>
                <p>Hesabınıza yeni bir şifre belirlemek için aşağıdaki adrese tıklayınız.</p>
                <p><a href="' . $siteUrl . 'forget-password/' . $token . '" style="background:#607d8b; color:#fff; widht:120px; padding:8px; font-size:16px;">PAROLAMI YENİLE</a></p>
                <p>Güvenliğiniz için bu bağlantıyı paylaşmayınız.</p>';
                //return self::mail($result->userMail, $result->userNameSurname, "Şifremi Unuttum?", $message);


            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public static function forgotToken($token)
    {
        return self::table("password_tokens")->where("token", $token)->first();
    }

    public static function resetPassword($mail, $password, $confirm_password)
    {
        if ($password != $confirm_password)
            return false;
        $result = self::table("users")->where(["userMail" => $mail, "status" => 1])->first();
        if ($result) {
            $passwordUpdate = self::table("users")->where("ID", $result->ID)->update([
                "userPassword" => md5($password)
            ]);

            if ($passwordUpdate) {
                $tokenDelete = self::table("password_tokens")->where("userID", $result->ID)->delete();
                return self::login($result->userMail, $confirm_password);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>