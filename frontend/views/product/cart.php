<?php
    \frontend\assets\MdbAsset::register($this);
    /**
     * Created by PhpStorm.
     * User: ROG
     * Date: 2020. 01. 11.
     * Time: 21:57
     */ ?>
<div class="container">

    <!-- Section: Product detail -->
    <section id="productDetails" class="pb-5">

        <!-- News card -->
        <div class="card mt-5 hoverable card-ecommerce">
            <div class="card-header">
                <h1>Cart</h1>
            </div>
            <div class="card-body">

                <!-- Shopping Cart table -->
                <div class="table-responsive">
                    <?php
                            $cartItems = Yii::$app->cart->getItems();
                            foreach($cartItems as $cartItem){
                                $product=$cartItem->getProduct();
                                echo $product->title;
                            }

                        ?>
                    <table class="table product-table">

                        <!-- Table head -->
                        <thead class="mdb-color lighten-5">
                        <tr>
                            <th></th>
                            <th class="font-weight-bold">
                                <strong>Product</strong>
                            </th>
                            <th class="font-weight-bold">
                                <strong>Color</strong>
                            </th>
                            <th></th>
                            <th class="font-weight-bold">
                                <strong>Price</strong>
                            </th>
                            <th class="font-weight-bold">
                                <strong>QTY</strong>
                            </th>
                            <th class="font-weight-bold">
                                <strong>Amount</strong>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <!-- /.Table head -->

                        <!-- Table body -->
                        <tbody>

                        <!-- First row -->
                        <tr>
                            <th scope="row">
                                <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/13.jpg" alt="" class="img-fluid z-depth-0">
                            </th>
                            <td>
                                <h5 class="mt-3">
                                    <strong>iPhone</strong>
                                </h5>
                                <p class="text-muted">Apple</p>
                            </td>
                            <td>White</td>
                            <td></td>
                            <td>$800</td>
                            <td class="text-center text-md-left">
                                <span class="qty">1 </span>
                                <div class="btn-group radio-group ml-2" data-toggle="buttons">
                                    <label class="btn btn-sm btn-primary btn-rounded waves-effect waves-light">
                                        <input type="radio" name="options" id="option1">—
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-rounded waves-effect waves-light">
                                        <input type="radio" name="options" id="option2">+
                                    </label>
                                </div>
                            </td>
                            <td class="font-weight-bold">
                                <strong>$800</strong>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove item">X
                                </button>
                            </td>
                        </tr>

                        <!-- /.First row -->


                        </tbody>
                        <!-- /.Table body -->

                    </table>

                </div>
                <!-- /.Shopping Cart table -->

            </div>

        </div>
    </section>
</div>