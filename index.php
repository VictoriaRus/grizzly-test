<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Grizzly-Test</title>
</head>
<body>
<div class="container pt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <h2 class="mb-2">Как узнать страну по коду?</h2>
            <form method="post" class="mb-3">
                <div class="row mb-3">
                    <label for="phone" class="col-12 col-form-label">Номер мобильного телефона</label>
                    <div class="col-lg-4">
                        <input type="text" name="phone" placeholder="Введите номер телефона"
                               class="form-control" id="phone">
                    </div>
                </div>
                <button type="submit" name="checkPhone" class="btn btn-primary">Узнать страну</button>
            </form>
            <p>
                <?php
                if (isset($_POST["checkPhone"]) && $_POST["phone"]) {
                    checkNumber($_POST["phone"]);
                } ?>
            </p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>


<?php
/**
 * Задание 1
 *
 */
function getPhoneCodes()
{
    $url = "https://cdn.jsdelivr.net/gh/andr-04/inputmask-multi@master/data/phone-codes.json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function leaveOnlyNumbers($phone)
{
    return preg_replace("/[^0-9]/", "", $phone);
}

function check($number, $mask)
{
    if (strncmp($number, $mask, strlen($mask)) === 0) {
        return true;
    }

    return false;
}

function checkNumber($number_phone)
{
    print "Номер телефона: " . $number_phone . "<br/>";

    $number = leaveOnlyNumbers($number_phone);
    $masks_phone = getPhoneCodes();

    foreach ($masks_phone as $value) {
        $mask = leaveOnlyNumbers($value["mask"]);

        if (strpos($number, $mask) !== false) {

            if (check($number, $mask)) {
                echo $value["mask"], " ", $value["name_ru"];
                return;
            }
        }
    }

}