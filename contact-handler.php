<?php
// contact-handler.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }
    
    // Email configuration
    $to = "adilqarnain@gmail.com"; // Change this to your email
    $subject = "New Contact Form Submission from " . $name;
    
    // Email body
    $email_body = "
    New contact form submission:
    
    Name: $name
    Email: $email
    Phone: $phone
    
    Message:
    $message
    
    ---
    Sent from your website contact form
    ";
    
    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Send email
    if (mail($to, $subject, $email_body, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Thank you! Your message has been sent.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error sending your message. Please try again.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>