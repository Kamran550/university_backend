<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Kabul Mektubu</title>
</head>

<body
    style="font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 10px; padding: 30px; margin-bottom: 20px;">
        <h1 style="color: #2c3e50; margin-bottom: 20px; font-size: 24px;">
            Sayın {{ $student->first_name }} {{ $student->last_name }},
        </h1>

        <p style="font-size: 16px; margin-bottom: 15px;">
            Avrupa Uluslararası Barış Üniversitesi'ne transfer başvurunuz ile ilgili önemli bir güncelleme paylaşmak
            istiyoruz.
        </p>

        <div
            style="background-color: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 16px; font-weight: bold; color: #155724;">
                ✓ Başvurunuz onaylanmıştır!
            </p>
        </div>

        <p style="font-size: 16px; margin-bottom: 15px;">
            Transfer Kabul Mektubunuz ekteki PDF dosyasında bulunmaktadır. Lütfen bu belgeyi dikkatlice inceleyiniz ve
            talimatları takip ediniz.
        </p>

        <div
            style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 14px; color: #856404;">
                <strong>Önemli:</strong> Kayıt işlemlerinizi tamamlamak için gerekli belgelerinizi belirlenen süre
                içinde teslim etmeniz gerekmektedir.
            </p>
        </div>

        <h2 style="color: #2c3e50; margin-top: 30px; margin-bottom: 15px; font-size: 18px;">
            Sonraki Adımlar:
        </h2>

        <ol style="font-size: 14px; line-height: 1.8; padding-left: 20px;">
            <li>Ekteki Transfer Kabul Mektubunu dikkatle okuyunuz</li>
            <li>Gerekli belgeleri hazırlayınız</li>
            <li>Kayıt tarihlerini not ediniz</li>
            <li>Sorularınız için bizimle iletişime geçiniz</li>
        </ol>

        <div style="background-color: #e7f3ff; border-radius: 8px; padding: 20px; margin: 25px 0;">
            <h3 style="color: #2c3e50; margin-top: 0; margin-bottom: 15px; font-size: 16px;">
                İletişim Bilgileri:
            </h3>
            <p style="margin: 5px 0; font-size: 14px;">
                <strong>E-posta:</strong> <a href="mailto:international@eipu.edu.pl"
                    style="color: #007bff; text-decoration: none;">international@eipu.edu.pl</a>
            </p>
            <p style="margin: 5px 0; font-size: 14px;">
                <strong>Telefon:</strong> +48 579 369 968
            </p>
            <p style="margin: 5px 0; font-size: 14px;">
                <strong>Web:</strong> <a href="https://www.eipu.edu.pl"
                    style="color: #007bff; text-decoration: none;">www.eipu.edu.pl</a>
            </p>
        </div>

        <p style="font-size: 14px; margin-top: 30px; color: #6c757d;">
            Ailemize katıldığınız için teşekkür ederiz. Size başarılı bir akademik yolculuk diliyoruz!
        </p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6;">
            <p style="font-size: 14px; margin: 5px 0;">
                <strong>Saygılarımızla,</strong>
            </p>
            <p style="font-size: 14px; margin: 5px 0;">
                Uluslararası Öğrenci İşleri Müdürlüğü
            </p>
            <p style="font-size: 14px; margin: 5px 0; color: #2c3e50; font-weight: bold;">
                Avrupa Uluslararası Barış Üniversitesi
            </p>
        </div>
    </div>

    <div
        style="text-align: center; font-size: 12px; color: #6c757d; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
        <p style="margin: 5px 0;">
            © {{ date('Y') }} Avrupa Uluslararası Barış Üniversitesi. Tüm hakları saklıdır.
        </p>
        <p style="margin: 5px 0;">
            Ogrodowa 58, 00-876 Varşova / Polonya
        </p>
    </div>
</body>

</html>
