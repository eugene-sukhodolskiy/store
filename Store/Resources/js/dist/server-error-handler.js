document.querySelector(".simple-err-disp").style.display = "none";

const eh_error = JSON.parse(eh_err);

const ehRenderCode = () => {
	let html = `<table class="eh-code" border="0" cellpadding="0" cellspacing="0">`;

	let linenum = 0;
	for(let i in eh_error.code) {
		strong = (i == eh_error.errline) ? `class="err-in-line"` : ``;
		html += `<tr ${strong}>
		<td class="lnum">${i}</td>
		<td class="lcode">${ehStrongDollar(ehStrongKeywords(ehStrongQuotes(eh_error.code[i])))}</td>
		</tr>`;
	}

	html += `</table>`;

	return html;
}

const ehStrongKeywords = code => {
	const keywords = [
		"var ", "function ", "class ", "return ", " extends ", "if", "foreach", "for",
		"interface ", "abstract ", "static ", "public ", 
		"protected ", "private ", "use ", "namespace ", "else", "switch", "elseif",
		"case", "default", " as ", "=&gt;", "-&gt;"
	];

	for(let key of keywords) {
		code = code.replaceAll(key, `<span data-eh="keyword">${key}</span>`);
	}

	return code;
}

const ehStrongDollar = code => {
	return code.replaceAll("$", `<span data-eh="dollar">$</span>`);
}

const ehStrongQuotes = code => {
	code = code.replaceAll("&quot;", `"`);
	code = code.replaceAll("&apos;", `'`);
	const words = [...code.matchAll(/".*?"/g), ...code.matchAll(/'.*?'/g)];
	words.forEach(i => {
		code = code.replace(i, `<span data-eh="q">${i}</span>`);
	});
	
	return code;	
}

const ehGetFileName = () => {
	let pathParticles = eh_error.errfile.split("/");
	return pathParticles[pathParticles.length - 1];
}

const ehGetPathToFile = () => {
	const filename = ehGetFileName();
	return eh_error.errfile.replace(filename, `<em>${filename}</em>`);
}

const ehRender = () => {
	let html = `<h2 class="eh-heading">${eh_error.err_type} #${eh_error.errno}</h2>`;
	html += `<h4 class="eh-heading">=&gt; ${eh_error.errstr}</h4>`;
	html += `<h4 class="eh-heading">${ehGetPathToFile()} [line <em>${eh_error.errline}</em>]</h4>`;
	html += ehRenderCode();
	const titleContainer = document.querySelector("title");
	titleContainer && (titleContainer.innerHTML = `${eh_error.err_type} => ${eh_error.errstr}`);
	document.querySelector(".error-handler").innerHTML = html;
}

window.addEventListener("DOMContentLoaded", e => {
	ehRender();
});