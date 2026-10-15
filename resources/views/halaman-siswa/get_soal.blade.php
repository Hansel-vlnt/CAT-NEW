<?php
	$jawab_siswa = '';
	$multi_jawabs = [];
	if ($soal->checkJawab) {
		$jawab_siswa = $soal->checkJawab->pilihan;
		if ($soal->tipe_soal == 'multi') {
			$decoded = json_decode($soal->checkJawab->jawaban_multi, true);
			$multi_jawabs = is_array($decoded) ? $decoded : explode(',', $jawab_siswa);
		}
	}
?>
<span class="detail_soal_id" style="display: none;">{{ $soal->id }}</span>
@if(!empty($prev->id))
<span id="prev_soal" style="display: none;">{{ $prev->id }}</span>
@endif
@if(!empty($next->id))
<span id="next_soal" style="display: none;">{{ $next->id }}</span>
@endif

<div style="margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
	@if($soal->tipe_soal == 'multi')
		<span class="label label-warning" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
			<i class="fa fa-check-square-o"></i> Pilihan Ganda Kompleks (Bisa pilih lebih dari 1 jawaban)
		</span>
	@elseif($soal->tipe_soal == 'tkp')
		<span class="label label-info" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
			<i class="fa fa-sliders"></i> Soal TKP (Skala Skor 1 - 5)
		</span>
	@else
		<span class="label label-default" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
			<i class="fa fa-dot-circle-o"></i> Pilihan Ganda (Pilih 1 jawaban terbaik)
		</span>
	@endif
	<span style="font-size: 12px; font-weight: 600; color: #64748b;">Bobot: {{ $soal->score }} Poin</span>
</div>

<div class="soal" style="font-size: 16px; line-height: 1.7; color: #0f172a; margin-bottom: 20px;">
	{!! $soal->soal !!}
</div>

<div class="opsi-container" data-tipe="{{ $soal->tipe_soal ?? 'single' }}" style="display: flex; flex-direction: column; gap: 10px;">
	<?php
		$opsi = [
			'A' => $soal->pila,
			'B' => $soal->pilb,
			'C' => $soal->pilc,
			'D' => $soal->pild,
			'E' => $soal->pile,
		];
	?>

	@foreach($opsi as $huruf => $teks)
		@if(!empty($teks))
			<?php
				$is_selected = false;
				if ($soal->tipe_soal == 'multi') {
					$is_selected = in_array($huruf, $multi_jawabs);
				} else {
					$is_selected = ($jawab_siswa == $huruf);
				}
			?>
			<div class="jawab {{ $is_selected ? 'dijawab' : '' }}"
				soal-id="{{ $soal->id_soal }}"
				data-id="{{ $soal->id }}"
				data-opsi="{{ $huruf }}"
				data-jawab="{{ $huruf.'/'.$soal->id.'/'.Auth::user()->id }}">
				<table width="100%">
					<tr>
						<td width="36px" valign="top">
							<span class="huruf-opsi">{{ $huruf }}.</span>
						</td>
						<td valign="top" class="pilihan" style="padding-top: 1px;">
							{!! $teks !!}
						</td>
					</tr>
				</table>
			</div>
		@endif
	@endforeach
</div>