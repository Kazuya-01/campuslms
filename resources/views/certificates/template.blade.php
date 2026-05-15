<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }

        body {
            font-family: 'DejaVu Sans', 'sans-serif';
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .wrapper {
            width: 100%;
            min-height: 100vh;
            position: relative;
            background: linear-gradient(135deg, #faf6f1 0%, #f5ede1 40%, #faf6f1 100%);
        }

        .bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.3;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 30px, rgba(193,168,120,0.06) 30px, rgba(193,168,120,0.06) 31px),
                repeating-linear-gradient(90deg, transparent, transparent 30px, rgba(193,168,120,0.06) 30px, rgba(193,168,120,0.06) 31px);
        }

        .border-frame {
            position: absolute;
            inset: 10px;
            border: 2px solid #c1a878;
        }

        .border-frame2 {
            position: absolute;
            inset: 15px;
            border: 1px solid #d4c5a9;
        }

        .corner {
            position: absolute;
            width: 35px;
            height: 35px;
            border-color: #c1a878;
            border-style: solid;
        }
        .corner.tl { top: 15px; left: 15px; border-width: 2px 0 0 2px; }
        .corner.tr { top: 15px; right: 15px; border-width: 2px 2px 0 0; }
        .corner.bl { bottom: 15px; left: 15px; border-width: 0 0 2px 2px; }
        .corner.br { bottom: 15px; right: 15px; border-width: 0 2px 2px 0; }

        .content {
            position: relative;
            z-index: 1;
            padding: 25px 45px;
            min-height: 90vh;
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .ribbon {
            display: inline-block;
            margin: 0 auto;
            background: linear-gradient(90deg, #c1a878, #d4c5a9, #c1a878);
            color: #4a3728;
            padding: 4px 35px;
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .title {
            font-family: Georgia, serif;
            font-size: 34px;
            font-weight: bold;
            color: #2c1810;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-top: 15px;
        }

        .gold-line {
            width: 160px;
            height: 2px;
            margin: 10px auto;
            background: linear-gradient(90deg, transparent, #c1a878, transparent);
        }

        .presented {
            font-size: 13px;
            color: #6a5a4a;
            margin: 5px 0;
            letter-spacing: 1px;
        }

        .student-name {
            font-family: Georgia, serif;
            font-size: 32px;
            font-weight: bold;
            color: #2c1810;
            margin: 5px 0;
        }

        .for-text {
            font-size: 13px;
            color: #6a5a4a;
            margin: 3px 0;
        }

        .course-name {
            font-family: Georgia, serif;
            font-size: 22px;
            font-weight: bold;
            color: #8a6d3b;
            margin: 3px 0 8px;
        }

        .desc {
            font-size: 11px;
            color: #8a7a6a;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .flex-spacer {
            flex: 1;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 5px;
        }

        .footer-item {
            text-align: center;
            flex: 1;
        }

        .sig-line {
            width: 140px;
            height: 1px;
            background: #2c1810;
            margin: 0 auto 5px;
        }

        .sig-title {
            font-size: 11px;
            font-weight: bold;
            color: #2c1810;
        }

        .sig-label {
            font-size: 9px;
            color: #8a7a6a;
        }

        .qr-box {
            text-align: center;
        }

        .cert-number {
            font-size: 8px;
            color: #aaa;
        }

        .seal {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 70px;
            height: 75px;
            border-radius: 50%;
            background: radial-gradient(circle, #f5ede1 30%, #c1a878 70%, #a08050 100%);
            border: 2px double #c1a878;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 2;
        }

        .seal-text {
            font-size: 6px;
            color: #4a3728;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .seal-star {
            font-size: 14px;
            color: #c1a878;
            line-height: 1;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 120px;
            font-weight: bold;
            color: #c1a878;
            opacity: 0.03;
            letter-spacing: 15px;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="bg-pattern"></div>
        <div class="border-frame"></div>
        <div class="border-frame2"></div>
        <div class="corner tl"></div>
        <div class="corner tr"></div>
        <div class="corner bl"></div>
        <div class="corner br"></div>
        <div class="watermark">CAMPUSLMS</div>

        <div class="content">
            <div><span class="ribbon">CampusLMS</span></div>

            <div class="title">Certificate of Completion</div>
            <div class="gold-line"></div>
            <p class="presented">This certificate is proudly presented to</p>

            <div class="student-name">{{ $certificate->user->name }}</div>

            <p class="for-text">for successfully completing the course</p>
            <div class="course-name">{{ $certificate->class->name }}</div>

            <p class="desc">
                This acknowledges the hard work, dedication, and successful completion
                of all required coursework and learning objectives.
            </p>

            <div class="gold-line"></div>

            <div class="flex-spacer"></div>

            <div class="footer">
                <div class="footer-item">
                    <div class="sig-line"></div>
                    <p class="sig-title">Rektor CampusLMS</p>
                    <p class="sig-label">Rector</p>
                </div>

                <div class="footer-item">
                    <p style="font-size: 10px; color: #8a7a6a;">Issued on</p>
                    <p style="font-size: 12px; color: #2c1810; font-weight: bold;">{{ ($certificate->issued_at ?? $certificate->created_at)->isoFormat('D MMMM Y') }}</p>
                    <p class="cert-number">{{ $certificate->certificate_number }}</p>
                </div>

                <div class="footer-item qr-box">
                    <div>{!! QrCode::size(45)->generate(url('/certificates/verify/' . $certificate->certificate_number)) !!}</div>
                    <p class="cert-number">Scan to verify</p>
                </div>
            </div>

            <div class="seal">
                <span class="seal-text">Verified</span>
                <span class="seal-star">★</span>
                <span class="seal-text">CampusLMS</span>
            </div>
        </div>
    </div>
</body>
</html>
