# Aplikasi PHP Machine Learning dengan Metode Naive Bayes - Codeigniter 4
Halaman Utama Aplikasi

![localhost_MKOM_PHP-ML_public_apps](https://user-images.githubusercontent.com/109882984/228162819-0ec26562-5796-4781-b537-14ec29ea5aa3.png)

CRUD Dataset
![localhost_MKOM_PHP-ML_public_apps_samples](https://user-images.githubusercontent.com/109882984/228163341-908ecc98-8fd0-4ddb-b9d5-725404ad8664.png)

Prediksi dan Hasil
![localhost_MKOM_PHP-ML_public_apps_predict (1)](https://user-images.githubusercontent.com/109882984/228163575-c3a35e82-cd26-403e-9538-cab113e56697.png)

Uji Prediksi dengan mebagi Data Training dan Dataset
![localhost_MKOM_PHP-ML_public_apps_performance (1)](https://user-images.githubusercontent.com/109882984/228163692-1565e290-ffa1-40e0-a528-fb8e829f081f.png)


## What is PHP-ML ?

PHP-ML merupakan sebuah library Machine Learning untuk bahasa pemrograman PHP. Library ini menyediakan berbagai tools untuk membuat sebuah sistem ML mulai dari reading data, preprocessing, training model, hingga testing. Untuk fungsi selengkapnya dapat dilihat di situs dokumentasi milik php-ml. Artikel ini akan memberikan contoh sederhana penggunaan php-ml.
Lihat Dokumentasi : https://php-ml.readthedocs.io/

## What is Naive Bayes ?
Naive bayes merupakan metode pengklasifikasian paling populer digunakan dengan tingkat keakuratan yang baik. Banyak penelitian tentang pengklasifikasian yang telah dilakukan dengan menggunakan algoritma ini. Berbeda dengan metode pengklasifikasian dengan logistic regression ordinal maupun nominal, pada algoritma naive bayes pengklasifikasian tidak membutuhkan adanya pemodelan maupun uji statistik.  



Naive bayes merupakan metode pengklasifikasian berdasarkan probabilitas sederhana dan dirancang agar dapat dipergunakan dengan asumsi antar variabel penjelas saling bebas (independen). Pada algoritma ini pembelajaran lebih ditekankan pada pengestimasian probabilitas. Keuntungan algoritma naive bayes adalah tingkat nilai error yang didapat lebih rendah ketika dataset berjumlah besar, selain itu akurasi naive bayes dan kecepatannya lebih tinggi pada saat diaplikasikan ke dalam dataset yang jumlahnya lebih besar.


## What is CodeIgniter ?
CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).


## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
