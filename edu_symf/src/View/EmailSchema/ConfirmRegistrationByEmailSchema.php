<?php

namespace App\View\EmailSchema;

use App\View\EmailSchema\DTO\GetMessageDTO;

class ConfirmRegistrationByEmailSchema
{
    public function getMessage($token): GetMessageDTO
    {
        $html = "<table border='0' cellpadding='0' cellspacing='0' style='margin:0; padding:0' width='100%'>
  <tr>
    <td>
      <center style='max-width: 604px; width: 100%;'>

        <table border='0' cellpadding='0' cellspacing='0' style='margin:0; padding:0' width='100%'>
  <tr>
    <td>
        <!-- Блок номер 1 -->
         <span style='display:inline-block; width:300px;'>
             Спасибо за регистрацию!
         </span>
        <!-- Блок номер 1 -->
        <!-- Блок номер 2 -->
         <span style='display:inline-block; width:300px;'>
              <a href='http://localhost:8000/users/registration/confirm/{$token}'>подтвердить регистрацию</a>
         </span>
        <!-- Блок номер 2 →

          </td>
        </tr>
      </table>
      </center>   
    </td>
  </tr>
</table>";
        $text = "Спасибо за регистрацию! Перейдите по ссылке чтобы подтвердить учетную запись: http://localhost:8000/users/registration/confirm/{$token}";

        return new GetMessageDto($html, $text);
    }
}