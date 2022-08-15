const error = JSON.parse(err);

const ehRenderCode = () => {
	let html = `<table class="eh-code" border="0" cellpadding="0" cellspacing="0">`;

	let linenum = 0;
	for(let i in error.code) {
		strong = (i == error.errline) ? `class="err-in-line"` : ``;
		html += `<tr ${strong}>
		<td class="lnum">${i}</td>
		<td class="lcode">${ehStrongDollar(ehStrongKeywords(error.code[i]))}</td>
		</tr>`;
	}

	html += `</table>`;

	return html;
}

const ehStrongKeywords = code => {
	const keywords = [
		"var ", "function ", "class ", "return ", " extends ", "if", "for", 
		"foreach", "interface ", "abstract ", "static ", "public ", 
		"protected ", "private ", "use ", "namespace ", "else", "switch", "elseif",
		"case", "default", " as "
	];

	for(let key of keywords) {
		code = code.replaceAll(key, `<span data-eh="keyword">${key}</span>`);
	}

	return code;
}

const ehStrongDollar = code => {
	return code.replaceAll("$", `<span data-eh="dollar">$</span>`);
}

const ehGetFileName = () => {
	let pathParticles = error.errfile.split("/");
	return pathParticles[pathParticles.length - 1];
}

const ehGetPathToFile = () => {
	const filename = ehGetFileName();
	return error.errfile.replace(filename, `<em>${filename}</em>`);
}

const ehRender = () => {
	let html = `<h2 class="eh-heading">${error.err_type} #${error.errno}</h2>`;
	html += `<h4 class="eh-heading">=&gt; ${error.errstr}</h4>`;
	html += `<h4 class="eh-heading">${ehGetPathToFile()} [line <em>${error.errline}</em>]</h4>`;
	html += ehRenderCode();
	document.querySelector(".error-handler").innerHTML = html;
}

window.addEventListener("DOMContentLoaded", e => {
	ehRender();
});