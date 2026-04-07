<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4c84ff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .contact-info {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #4c84ff;
        }
        .contact-details {
            margin: 15px 0;
        }
        .contact-details table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .contact-details th,
        .contact-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .contact-details th {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #4c84ff;
        }
        .message-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4c84ff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-new {
            background-color: #ffc107;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
    </div>
    
    <div class="content">
        <p>Hello Admin,</p>
        
        <p>A new contact form submission has been received on your website. Here are the details:</p>
        
        <div class="contact-info">
            <h2>Contact Information</h2>
            <table class="contact-details">
                <tr>
                    <th>Name</th>
                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
                </tr>
                <tr>
                    <th>Submitted</th>
                    <td>{{ $contact->created_at->format('F d, Y h:i A') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="status-badge status-new">{{ ucfirst($contact->status) }}</span>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="message-box">
            <h3>Message</h3>
            <div class="message-content">{{ $contact->message }}</div>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="button">View Contact Message</a>
        </div>
    </div>
    
    <div class="footer">
        <p>This is an automated notification from {{ config('app.name') }}</p>
        <p>Contact ID: #{{ $contact->id }}</p>
    </div>
</body>
</html>

