<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Two-Factor Authentication Code</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f7; font-family: 'Helvetica Neue', Arial, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color: #4f46e5; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px;">Two-Factor Authentication</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px; text-align: center;">
                            <p style="font-size: 18px; color: #333;">Hello,</p>
                            <p style="font-size: 16px; color: #555; margin: 20px 0;">
                                Your authentication code is:
                            </p>
                            <p style="font-size: 32px; color: #4f46e5; margin: 20px 0; font-weight: bold;">
                                {{ $code }}
                            </p>
                            <p style="font-size: 14px; color: #777; margin: 30px 0;">
                                This code will expire in 10 minutes.
                            </p>
                            <p style="font-size: 12px; color: #999;">
                                If you did not request this code, please ignore this email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color: #f4f4f7; text-align: center; padding: 20px; font-size: 12px; color: #aaa;">
                            &copy; {{ date('Y') }} Amanah Raya Trustees Berhad. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
