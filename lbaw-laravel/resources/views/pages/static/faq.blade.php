@extends('layouts.app')

@section('title', 'Vecto: Index')

@section('content')

<div class="container faq">
	<div id="accordion">
		<div class="faqHeader">
			<strong>General questions</strong>
		</div>
		<div class="card">
			<div class="card-header border-0" id="headingOne">
				<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<h4 class="card-title">Is account registration required?</h4>
				</button>
			</div>
		
			<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">
					Account registration at
					<strong>Vecto</strong> is only required if you will be creating posts and voting for them. This ensures a valid sharing channel
					for all parties involved in this community.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header border-0" id="headingTwo">
				<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					<h4 class="card-title">Can I submit my own Erasmus story?</h4>
				</button>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
				<div class="card-body">
					Sure, just register your account.
				</div>
			</div>
		</div>
		<div class="faqHeader">
			<strong>Users</strong>
		</div>
		<div class="card">
			<div class="card-header border-0" id="headingThree">
				<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					<h4 class="card-title">Who can create posts?</h4>
				</button>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
				<div class="card-body">
					Any registed user, with a genuine and appealing post, can post it, including <strong>YOU</strong>.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header border-0" id="headingFour">
				<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
					<h4 class="card-title">I want to create a post - what are the steps?</h4>
				</button>
			</div>
			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
				<div class="card-body">
					The steps involved in this process are really simple. All you need to do is:
					<ul>
						<li>Register an account</li>
						<li>Activate your account</li>
						<li>Go to the University you belong to and upload your story.</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="faqHeader">
			<strong>What else can I do?</strong>
		</div>
		<div class="card">
			<div class="card-header border-0" id="headingFive">
				<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
					<h4 class="card-title">Can I use this as a social media platform?</h4>
				</button>
			</div>
			<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
				<div class="card-body">
					Sure, why not?
					<br /> I mean, we're not going to
					<strong>sell</strong> your information to the highest bidder or anything...
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header border-0" id="headingSix">
				<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
					<h4 class="card-title">Can I pay you a beer?</h4>
				</button>
			</div>
			<div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
				<div class="card-body">
					Of course you can, just click this
					<strong>Donate</strong> button :)
				</div>
			</div>
		</div>
	</div>
</div>

@endsection