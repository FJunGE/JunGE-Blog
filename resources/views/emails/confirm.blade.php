@component('mail::message')
# 感谢您在 JunGE APP 网站进行注册！

---
请点击下面的按钮完成注册：
@component('mail::button', ['url' => $url ])
点击我完成注册
@endcomponent
<br>如果这不是您本人的操作，请忽略此邮件。

Thank, JunGE APP
@endcomponent