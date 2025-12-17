<!DOCTYPE html>
<html>
<head>
    <title>Thông báo hủy lịch phỏng vấn</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Xin chào {{ $interview->jobApplication->user->name }},</h2>
    
    <p>Chúng tôi rất tiếc phải thông báo rằng lịch phỏng vấn cho vị trí <strong>{{ $interview->jobApplication->job->title }}</strong> tại <strong>{{ $interview->jobApplication->job->employerProfile->company_name ?? 'Công ty' }}</strong> dự kiến vào lúc {{ $interview->scheduled_at->format('H:i d/m/Y') }} đã bị hủy.</p>
    
    <div style="background-color: #fff1f2; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #fecaca;">
        <h3 style="margin-top: 0; color: #991b1b;">Lý do hủy:</h3>
        <p style="color: #7f1d1d;">{{ $interview->cancellation_reason }}</p>
    </div>

    <p>Chúng tôi sẽ liên hệ lại với bạn để sắp xếp lịch mới nếu có thể. Rất xin lỗi vì sự bất tiện này.</p>
    
    <p>Trân trọng,<br>Đội ngũ tuyển dụng.</p>
</body>
</html>
