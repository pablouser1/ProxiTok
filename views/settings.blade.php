<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Settings - TikTok</title>
  <link rel="stylesheet" href="https://unpkg.com/bulmaswatch/superhero/bulmaswatch.min.css">
</head>
<body>
  @include('navbar')
  <section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<p class="title">Settings</p>
			</div>
		</div>
  </section>
  <section class="section">
		<!-- Proxy settings -->
		<p class="title">Proxy</p>
		<form action="./settings" method="POST">
			@foreach ( $proxy_elements as $element)
			<div class="field">
				<label class="label">{{ $element }}</label>
				<div class="control">
          <input name="{{ $element }}" class="input" value="{{ isset($_COOKIE[$element]) ? $_COOKIE[$element] : ''}}" required />
        </div>
      </div>
      @endforeach
      <div class="field">
        <div class="control">
          <button class="button is-success" type="submit">Submit</button>
        </div>
      </div>
    </form>
  </section>
  @include('footer')
</body>
</html>
