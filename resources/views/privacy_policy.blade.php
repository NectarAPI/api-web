@extends('header')

@section('title')
Privacy Policy
@endsection('title')

@section('page-body')

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Privacy Policy</h4>
          </div>
        </div>

        <div class="row">
          <div class="section">
Sydye ("us", "we", or "our") operates <a href="https://portal.nectar.software" class="href">https://portal.nectar.software</a> (the "Portal") 
and https://api.nectar.software (the "API"). This page informs you of our policies regarding the collection, use and disclosure of 
Personal Information we receive from users of the Portal and the API (collectively the "Platform"). 
          </div>
          <div class="section">
We use your Personal Information only for providing and improving the Platform. By using the Platform, you agree to the collection and use of 
information in accordance with this policy.
          </div>


<h5>Information Collection And Use</h5>

<div class="section">
While using the Platform, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. 
Personally identifiable information may include, but is not limited to your name ("Personal Information").
</div>

<h5>Log Data</h5>

<div class="section">
Like many site operators, we collect information that your browser sends whenever you use the Platform
("Log Data"). This Log Data may include information such as your computer's Internet Protocol ("IP") address,
browser type, browser version, the pages and endpoints of our Portal that you visit, the time and date of your visit,
the time spent on those pages and other statistics. In addition, we may use third party services such as Google 
Analytics that collect, monitor and analyze this.
</div>

<h5>Communications</h5>

<div class="section">
We may use your Personal Information to contact you with newsletters, marketing or promotional materials and other relevant information.
</div>

<h5>Cookies</h5>

<div class="section">
Cookies are files with small amount of data, which may include an anonymous unique identifier.
Cookies are sent to your browser from a web site and stored on your computer's hard drive.
Like many sites, we use "cookies" to collect information when you visit the Portal. You can instruct 
your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not 
accept cookies, you may not be able to use some portions of our Portal.
</div>


<h5>Security</h5>

<div class="section">
The security of your Personal Information is important to us, but remember that no method of
transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to
use commercially acceptable means to protect your Personal Information, we cannot guarantee its
absolute security.
</div>


<h5>Changes To This Privacy Policy</h5>

<div class="section">
This Privacy Policy is effective as of 1st May, 2017 and will remain in effect except with respect to any
changes in its provisions in the future, which will be in effect immediately after being posted on this
page.
</div>

<div class="section">
We reserve the right to update or change our Privacy Policy at any time and you should check this
Privacy Policy periodically. Your continued use of the Portal after we post any modifications to the
Privacy Policy on this page will constitute your acknowledgment of the modifications and your
consent to abide and be bound by the modified Privacy Policy.
</div>

<div class="section">
If we make any material changes to this Privacy Policy, we will notify you either through the email
address you have provided us, or by placing a prominent notice on our website.
</div>


<h5>Contact Us</h5>

<div class="section">
If you have any questions about this Privacy Policy, please contact us at <a href="mailto:info@nectar.software">info@nectar.software</a>.
</div>

        </div>
      </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
    @include('footer')

  </div>

  <style>
    .section {
      margin-top: 1em;
    }
    h5 {
      margin-top: 2em;
      font-size: 18px;
      display: block;
      width: 100%;
    }
  </style>

@endsection