<script>
	function commit(name) {
		console.log('commit');
		var editable = document.getElementById(name + '-editable');
		var textarea = document.getElementById(name + '-textarea');
		if (editable.style.display === 'block') {
			var html = editable.innerText;
			textarea.value = html;    // update textarea for form submit
		} else {
			var html = textarea.value;
			editable.innerText = html;    // update editable
		}
	}
	function sethtml(name, editorMode = 'regular') {
		var bold = document.getElementById(name + '-bold');
		var italic = document.getElementById(name + '-italic');
		var link = document.getElementById(name + '-link');
		var indent = document.getElementById(name + '-indent');
		var reset = document.getElementById(name + '-reset');
		var image = document.getElementById(name + '-image');
		var imagecontainer = document.getElementById(name + '-imagecontainer');
		var html = document.getElementById(name + '-html');
		var txt = document.getElementById(name + '-txt');
		var editable = document.getElementById(name + '-editable');
		var textarea = document.getElementById(name + '-textarea');

		textarea.style.display = 'block';
		editable.style.display = 'none';

		html.style.display = 'none';
		txt.style.display = 'block';

		bold.style.visibility = 'hidden';
		italic.style.visibility = 'hidden';
		indent.style.visibility = 'hidden';
		reset.style.visibility = 'hidden';
		link.style.visibility = 'hidden';
		image.style.visibility = 'hidden';
		imagecontainer.style.display = 'none';

		var html = editable.innerText;
		textarea.value = pretty(html);    // update textarea for form submit
		if(editorMode == 'regular')
			window.scrollBy(0, textarea.getBoundingClientRect().top); // scroll to the top of the textarea
	}
</script>
<?
$generate_url = implode("/", $uu->urls);
$g = $host.$generate_url;
			?><div id="footer-container" class="flex-min">
				<footer class="centre">
					<? if ($view != "logout"): ?>
						<a class="button" href="<? echo $admin_path; ?>info">INFO</a>
						<?php if (count($uu->urls) > 1): ?>
						<a class="button" href="<? echo $admin_path."report/".$uu->urls(); ?>" target="_blank">GENERATE</a>
						<?php else: ?>
						<span class="button" href="<? echo $admin_path."report/".$uu->urls(); ?>" target="_blank">GENERATE</span>
						<?php endif; ?>
						<?php if ($user != 'guest'): ?>
							<a class="button" href="<? echo $admin_path; ?>settings">SETTINGS</a>
						<?php endif; ?>
						<a class="button" href="<? echo $admin_path; ?>logout" style="float: right;">LOG OUT</a>
					<? endif; ?>
				</footer>
			</div>
		</div>
	</body>
</html><?
$db-> close();
?>
