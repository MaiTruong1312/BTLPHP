<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật lịch phỏng vấn</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Xin chào {{ $interview->jobApplication->user->name }},</h2>
    
    <p>Nhà tuyển dụng <strong>{{ $interview->jobApplication->job->employerProfile->company_name ?? 'Công ty' }}</strong> đã cập nhật thông tin lịch phỏng vấn của bạn cho vị trí <strong>{{ $interview->jobApplication->job->title }}</strong>.</p>
    
    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h3 style="margin-top: 0;">Thông tin cập nhật:</h3>
        <ul style="list-style: none; padding-left: 0;">
            <li><strong>🕒 Thời gian mới:</strong> {{ $interview->scheduled_at->format('H:i - d/m/Y') }}</li>
            <li><strong>📍 Địa điểm/Link:</strong> {{ $interview->location }}</li>
            <li><strong>💻 Hình thức:</strong> {{ ucfirst($interview->type) }}</li>
        </ul>
    </div>

    <p>Vui lòng sắp xếp thời gian tham gia đúng giờ. Nếu có thắc mắc, vui lòng liên hệ lại với chúng tôi.</p>
    <p>Trân trọng,<br>Đội ngũ tuyển dụng.</p>
</body>
</html>
