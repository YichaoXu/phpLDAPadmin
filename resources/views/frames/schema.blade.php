@extends('layouts.dn')

@section('page_title')
	<table class="table table-borderless">
		<tr>
			<td style="border-radius: 5px;"><div class="page-title-icon f32"><i class="fas fa-fingerprint"></i></div></td>
			<td class="top text-right align-text-top p-0 pt-2"><strong>{{ \App\Ldap\Entry::schemaDN() }}</strong><br><small>{{ $o->entryuuid[0] ?? '' }}</small></td>
		</tr>
	</table>
@endsection

@section('main-content')
	<div class="main-card mb-3 card">
		<div class="card-body"><h5 class="card-title">{{ __('Schema Information') }}</h5>
			<ul class="nav nav-tabs">
				<li class="nav-item"><a data-toggle="tab" href="#objectclasses" class="nav-link">{{ __('Object Classes') }}</a></li>
				<li class="nav-item"><a data-toggle="tab" href="#attributetypes" class="nav-link">{{ __('Attribute Types') }}</a></li>
				<li class="nav-item"><a data-toggle="tab" href="#ldapsyntaxes" class="nav-link">{{ __('Syntaxes') }}</a></li>
				<li class="nav-item"><a data-toggle="tab" href="#matchingrules" class="nav-link">{{ __('Matching Rules') }}</a></li>
			</ul>
			<div class="tab-content">
				<!-- Object Classes -->
				<div class="tab-pane" id="objectclasses" role="tabpanel">
					<div id="schema.objectclasses"><i class="fas fa-fw fa-spinner fa-pulse"></i></div>
				</div>

				<!-- Attribute Types -->
				<div class="tab-pane" id="attributetypes" role="tabpanel">
					<div id="schema.attributetypes"><i class="fas fa-fw fa-spinner fa-pulse"></i></div>
				</div>

				<!-- Syntaxes -->
				<div class="tab-pane" id="ldapsyntaxes" role="tabpanel">
					<div id="schema.ldapsyntaxes"><i class="fas fa-fw fa-spinner fa-pulse"></i></div>
				</div>

				<!-- Matching Rules -->
				<div class="tab-pane" id="matchingrules" role="tabpanel">
					<div id="schema.matchingrules"><i class="fas fa-fw fa-spinner fa-pulse"></i></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page-scripts')
	<script type="text/javascript">
		var loaded = [];

		$(document).ready(function() {
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (item) {
				// activated tab
				var type = $(item.target).attr('href').substring(1);
				if (loaded[type])
					return false;

				$.ajax({
					url: '{{ url('api/schema/view') }}',
					method: 'POST',
					data: { type: type },
					dataType: 'html',

				}).done(function(html) {
					$('div[id="schema.'+type+'"]').empty().append(html);
					loaded[type] = true;

				}).fail(function() {
					alert('Failed');
				});

				item.stopPropagation();
			});

			// Open our objectclasses tab automatically
			$('.nav-item a[href="#objectclasses"]').tab('show');
		});
	</script>
@append