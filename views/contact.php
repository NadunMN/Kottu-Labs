<!-- <h1>contact</h1>

<form action="" method="post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>
    <link rel="stylesheet" href="/CSS/contact.css" />
  </head>
  <body>
    <div class="container">
      <header class="header">
        <h1>Our Branches</h1>
      </header>

      <!-- Branch 1 -->
      <section class="branch">
        <h2>Branch 1: Wattala</h2>
        <p><strong>Address:</strong> 190, 3 Negambo Rd, Wattala 11104</p>
        <p><strong>Phone:</strong> 076 130 1478</p>
      </section>

      <!-- Branch 2 -->
      <section class="branch">
        <h2>Branch 2: Kelaniya</h2>
        <p><strong>Address:</strong> 540, Kandy Rd, Kelaniy 11300</p>
        <p><strong>Phone:</strong> 077 712 0815</p>
      </section>

      <!-- Branch 3 -->
      <section class="branch">
        <h2>Branch 3: Kotahena</h2>
        <p><strong>Address:</strong> 51/C, Green Lane, Kotahena, Colombo 13</p>
        <p><strong>Phone:</strong> 077 668 0000</p>
      </section>

      <!-- Contact Form -->
      <section class="reservation">
        <div class="call-us">
          <button>Call Us</button>
        </div>
        <form id="reservationForm">
          <input
            type="text"
            id="name"
            name="name"
            placeholder="Enter your Name"
            required
          />
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter email address"
            required
          />
          <textarea
            id="message"
            name="message"
            placeholder="Enter your message"
            required
          ></textarea>
          <button type="submit">Submit</button>
        </form>
      </section>
    </div>
    <script src="/JavaScript/contact.js"></script>
  </body>
</html>
