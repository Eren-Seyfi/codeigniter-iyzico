<h1>Ödeme Başarılı!</h1>
<p>Mesaj: <?php echo $message; ?></p>
<p>Ödeme Durumu: <?php echo $paymentStatus; ?></p>
<h2>Ödeme Detayları</h2>
<pre><?php echo json_encode(json_decode($rawData), JSON_PRETTY_PRINT); ?></pre>
