<html>

<head>
    <!-- <title>Send Mail</title> -->
</head>
<style>
            th{
                border:1px solid black;
                background:#ddd;
            }
            td{
                text-align:center;
            }
            tbody td{
                border:1px solid black;
            }
        </style>
<body>
    <p>
        Hi <b><?= $data['First_Name']; ?></b> Good day!
        <br>
        <br>
        <?= $message; ?>
        <!-- Hi, This is <?php echo $fullname; ?> from the Digital Education Solutions unit of the ICT Department.
        <br> -->
        <!-- We are glad to inform you that we have successfully printed your ID, you may now claim it at DES Office located at the Computer Laboratory 2, 5th Floor, GD 1 -->
        <!-- We would like to inform you that your proof of payment has been rejected, please upload a valid proof of payment. -->
        <?php if($proof_table!=null):?>
        <table width="80%" cellspacing="0">
            <tr>
                <th style="border:1px solid black;background:#ddd;">Payment Type</th>
                <?php
                if($data['payment_type']=='Bank Deposit'){
                ?>
                <th style="border:1px solid black;background:#ddd;">Bank Name</th>
                <th style="border:1px solid black;background:#ddd;">Card No.</th>
                <th style="border:1px solid black;background:#ddd;">Card Holder Name</th>
                <?php
                }
                else{
                ?>
                <th style="border:1px solid black;background:#ddd;">Payment Method</th>
                <th style="border:1px solid black;background:#ddd;">Payment Ref. Number</th>
                <?php
                }
                ?>
                <th style="border:1px solid black;background:#ddd;">Total_amount paid</th>
            </tr>
            <tr>
                <td style="text-align:center;"><?= $data['payment_type'];?></td>
                <?php
                if($data['payment_type']=='Bank Deposit'){
                ?>
                <td style="text-align:center;"><?= strtoupper($data['bank_type']) ?></td>
                <td style="text-align:center;"><?= strtoupper($data['acc_num']) ?></td>
                <td style="text-align:center;"><?= strtoupper($data['acc_holder_name']) ?></td>
                <?php
                }
                else{
                ?>
                
                <td style="text-align:center;"><?= $data['payment_type']=="SDCA Online Payment"?$data['payment_type']:$data['bank_type'] ;?></td>
                <td style="text-align:center;"><?= strtoupper($data['payment_reference_no']) ?></td>
                <?php
                }
                ?>
                <td style="text-align:center;"><?= 'P '.strtoupper(number_format($data['amount_paid'],'2','.',',')) ?></td>
            </tr>
        </table>
        <?php endif; ?>
        <br>
        <br>
        If you have any concerns, please don't hesitate to email us.
        <br>
        Thank you.
    </p>
</body>

</html>