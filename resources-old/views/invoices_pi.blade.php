<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>PI Load {{$loadnumbers}}</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .invoice-content {
        font-family: 'Poppins', sans-serif;
        color: #000;
        font-size: 14px;
    }

    .invoice-content a {
        text-decoration: none;
    }

    .invoice-content .img-fluid {
        max-width: 100% !important;
        height: auto;
    }

    .invoice-content .form-control:focus {
        box-shadow: none;
    }

    .invoice-content h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
        font-family: 'Poppins', sans-serif;
        color: #000;
    }


    /** BTN LG **/
    .btn-lg {
        font-size: 14px;
        height: 50px;
        padding: 0 30px;
        line-height: 50px;
        border-radius: 3px;
        color: #ffffff;
        border: none;
        margin: 0 3px 3px;
        display: inline-block;
        vertical-align: middle;
        -webkit-appearance: none;
        text-transform: capitalize;
        transition: all 0.3s linear;
        z-index: 1;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .btn-lg:hover {
        color: #ffffff;
    }

    .btn-lg:hover:after {
        transform: perspective(200px) scaleX(1.05) rotateX(0deg) translateZ(0);
        transition: transform 0.9s linear, transform 0.4s linear;
    }

    .btn-lg:after {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        content: "";
        transform: perspective(200px) scaleX(0.1) rotateX(90deg) translateZ(-10px);
        transform-origin: bottom center;
        transition: transform 0.9s linear, transform 0.4s linear;
        z-index: -1;
    }

    .btn-check:focus+.btn,
    .btn:focus {
        outline: 0;
        box-shadow: none;
    }


    .btn-download {
        background: #399f07;
    }

    .btn-download:after {
        background: #46ca04;
    }

    .btn-print {
        background: #3a3939;
    }

    .btn-print:after {
        background: #1d1c1c;
    }


    /** Invoice 2 Start **/
    .invoice-2 {
        padding: 30px 0;
    }

    .invoice-2 .mb-30 {
    margin-bottom: 13px;
}

    .invoice-2 .invoice-info {
        background: #fff;
        position: relative;
    }

    .invoice-2 .name {
    font-size: 12px;
    margin-bottom: 4px;
    text-transform: uppercase;
    color: #262525;
    font-weight: 700;
}
.invoice-top h6 {
    font-size: 12px;
}

    .invoice-2 .invoice-number-inner {
        max-width: 200px;
        margin-left: auto;
    }

    .invoice-2 .payment-method-list-1 {
        padding: 0;
    }

    .invoice-2 .item-desc-1 span {
        font-size: 14px;
        font-weight: 500;
    }

    .invoice-2 .payment-method ul {
        list-style: none;
    }

    .invoice-2 .payment-method ul li strong {
        font-weight: 500;
    }


    .invoice-2 .invoice-top {
        font-size: 15px;
    }
    p {
    font-size: 12px;
    margin: 3px 0;
}
td {
    padding: 2px 10px !important;
}
.invoice-top .detail {
    padding: 8px 22px;
    margin-bottom: 19px;
    border-radius: 7px;
    background: #f7f7f7;
    border: 1px solid #cccc;
}
.invoice-top .detail b{
    margin-right: 11px;
}
.invoice-2 .inv-title-1 {
    color: #399f07;
    margin-bottom: 5px;
    font-weight: 500;
    font-size: 17px;
}


    .invoice-2 img {
        width: 50%;
    margin-bottom: 17px;

    }

    .invoice-2 .invoice-id .info {
        max-width: 100%;
    }





    .invoice-2 .invoice-bottom {
        padding: 0 50px 10px;
    }


    .invoice-2 .invoice-contact {
        padding: 20px 0 20px;
        background-image: linear-gradient(to bottom, #a3ca40, #527200);
    }

    .invoice-2 .contact-info a {
        margin: 0 30px 10px 0;
        color: #fff;
        font-size: 14px;
        line-height: 50px;
    }

    .invoice-2 .contact-info a i {
        width: 50px;
        height: 50px;
        background: #ffffff;
        text-align: center;
        font-size: 20px;
        line-height: 50px;
        margin-right: 10px;
        color: #399f07;
        border-radius: 60px;
    }

    .invoice-2 .invoice-contact h3 {
        font-size: 20px;
    }

    .invoice-2 .contact-info .mr-0 {
        margin-right: 0;
    }

    .invoice-2 .inv-header-1 {
    font-weight: 600;
    color: #399f07;
    font-size: 18px;
}



    /** MEDIA **/
    @media (max-width: 992px) {}

    @media (max-width: 768px) {}

    @media (max-width: 580px) {}
</style>
<script>
        window.onload = function() {
            window.print();
        };
    </script>
<body>

    <!-- Invoice 2 start -->
    <div class="invoice-2 invoice-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner clearfix">
                        <div class="invoice-info clearfix" id="invoice_wrapper">
                            <div class="invoice-headar">
                                <div class="row">
                                    <div class="col-sm-6">
                                            <div class="logo">
                                                <img src="{{ asset('public/images/invoice-logo.png') }}">
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-id">
                                            <div class="info">
                                                <p>Cargo Convoy Inc.</p>
                                                <p>7119, Pennsylvania Ave.</p>
                                                <p>Upper Darby, PA - 19082</p>
                                                <p>610-400-7068</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-id">
                                            <div class="info">
                                                <h1 class="inv-header-1">Invoice</h1>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td style="width:60%"><p class="mb-1"><b>Date:</b> <span>{{date('m/d/Y')}}</span></p></td>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <td style="width:60%"><p class="mb-1"><b>Invoice Number:</b> <span>{{$loadnumbers}}</span></p></td>
                                                    </tr>
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <h4 class="inv-title-1">Bill To</h4>
                                            <hr>
                                            <p class="invo-addr-1">
                                               <p>{{$customer->customer_name ?? ''}}</p> 
                                               <p>{{$customer->customer_address ?? ''}} {{$customer->customer_city ?? ''}}, {{$customer->customer_state ?? ''}}, {{$customer->customer_zip ?? ''}}, {{ preg_replace('/^\d+\s*/', '', $customer->customer_country ?? '') }}</p> 
                                            </p>
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <h4 class="inv-title-1">Remit To</h4>
                                            <hr>
                                            <p class="invo-addr-1">
                                                <p>Account Name : Cargo Convoy Inc.</p>
                                                <p>Type : Checking</p>
                                                <p>Bank Name : Chase Bank</p>
                                                <p>Account Number : 672578880</p>
                                                <p>Routing Number : 083000137</p>
                                                <p>Bank Address : 3604 West Chester Pike, Newtown Square, PA</p>
                                                <p>19073, United State</p>
                                                <p></p>
                                                <p>Email : Ar@cargoconvoy.co</p>
                                            </p>
                                            </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="invoice-top">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>DESCRIPTION</th>
                                        <th>LOAD</th>
                                        <th>UNIT PRICE</th>
                                        <th>TOTAL</th>
                                        <th>REMARKS</th>
                                    </tr>
                                    @foreach($invoice as $data)
                                    <tr>
                                        <td>{{$data['load_workorder']}}</td>
                                        <td>{{$data['load_number']}}</td>
                                        <td></td>
                                        <td>{{$data['total']}}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row invoice-bottom">
                                    <div class="col-sm-6">
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-id">
                                            <div class="info">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b>SUBTOTAL :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span>${{$total_amount}}</span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b>DISCOUNT :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span>0.00</span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b>SUBTOTAL LESS DISCOUNT :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span></span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b>TAX RATE :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span>0.00%</span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b>TOTAL TAX :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span>0.00</span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b>SHIPPING/HANDLING :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span>0.00</span></p></td>
                                                    </tr> 
                                                    <tr>
                                                        <td style="width:50%"><p class="mb-1"><b> Balance Due :</b></p></td>
                                                        <td style="width:50%"><p class="mb-1"><span>${{$total_amount}}</span></p></td>
                                                    </tr>                                                     
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 2 end -->
</body>

</html>