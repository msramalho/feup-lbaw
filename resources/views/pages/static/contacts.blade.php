@extends('layouts.app')

@section('title', 'Vecto: Contacts')

@section('content')

<div class="container">
	<div class="jumbotron">
		<h1>Contacts Page of Vecto</h1>
		<p class="lead">Consider vivisiting our
			<a href="{{url("faq")}}">FAQ</a> before submitting a direct contact request</p>
		<p>To get in touch with the
			<i>Vecto</i> team you can</p>
		<dl>
			<dt>Design Team</dt>
			<dd>Phone
				<a href="tel:123-456-789">123-456-789</a> or send an email to
				<a href="mailto:fakemail@vecto.io">not.design@vecto.io</a>.</dd>
			<dt>Public Relations Team</dt>
			<dd>Phone
				<a href="tel:123-456-788">123-456-788</a> or send an email to
				<a href="mailto:fakemail@vecto.io">not.pr@vecto.io</a>.</dd>
			<dt>Development Team</dt>
			<dd>Phone
				<a href="tel:123-456-787">123-456-787</a> or send an email to
				<a href="mailto:fakemail@vecto.io">not.dev@vecto.io</a>.</dd>
			<dt>Content Management Team</dt>
			<dd>Phone
				<a href="tel:123-456-789">123-456-786</a> or send an email to
				<a href="mailto:fakemail@vecto.io">not.content@vecto.io</a>.</dd>
		</dl>
	</div>
</div>

@endsection