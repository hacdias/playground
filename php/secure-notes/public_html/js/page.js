$(document).ready(function () {
    setTimeout(changeBackground, 500);
});

var url = "http://74d81983.ngrok.io/";

var changeBackgroundNum = 0;
var changeBackground = function () {

    var colors = [
        "#F44336",
        "#9C27B0",
        "#E91E63",
        "#2196F3",
        "#009688",
        "#CDDC39",
        "#FF9800",
        "#FF5722"];

    $(".autoBackgroud").css('background', colors[changeBackgroundNum]);

    if (changeBackgroundNum === 7) {
        changeBackgroundNum = 0;
    } else {
        changeBackgroundNum++;
    }

    setTimeout(changeBackground, 5000);

    return false;
}

var createNoteAdviceNumber = 0;
var createNote = function () {

    var alertBox = $(".advice-box");
    var password = $("#password").val();
    var content = $("#content").val();

    if (content === '' || password === '') {

        alertBox.html('You must fill all boxes.');

        if (createNoteAdviceNumber === 0) {
            alertBox.addClass('red-box').fadeIn();
            createNoteAdviceNumber++;
        } else {
            alertBox.effect('shake');
            createNoteAdviceNumber++;
        }

    } else {

        //content = escapeHtmlEntities(content);
        var encryption = encryptContent(content);

        password = passwordHash(password);

        var data = {
            content: encryption.content,
            password: password,
            iv: encryption.iv
        }

        $.ajax({
            type: 'POST',
            url: url + 'api/note/add',
            data: data,
            dataType: 'json'

        }).done(function (response) {

            if (response.url) {
                window.location.href = response.url + '#' + encryption.key;
            }

        }).fail(function (xhr, desc, err) {

            alertBox.html('Something went wrong!').addClass('red-box').fadeIn();

        });
    }
}

var submitViewPasswordAdviceNumber = 0;
var submitViewPassword = function () {

    var password = $("#password").val();

    var path = window.location.pathname.split('/');
    var id = path[(path.length - 1)];

    if (password === '') {

        displayMessage('You must write the password.', 'red');

    } else {

        password = passwordHash(password);

        var data = {
            password: password,
            id: id
        };

        $.ajax({
            type: 'POST',
            url: url + 'api/note/view',
            data: data,
            dataType: 'json'

        }).done(function (response) {

            if (response.status) {
                hideMessage();

                $('#insert-password').fadeOut().addClass('hidden');
                $('#view-note').fadeIn().removeClass('hidden');

                decryptContent(response.content, response.iv);

            } else {
                displayMessage('Wrong Password! Try again.', 'red');
            }

        }).fail(function (xhr, desc, err) {

            displayMessage('Something went wrong.', 'red');

        });
    }
}

var passwordHash = function (password) {
    var md = forge.md.sha512.create();
    md.update(password);
    final = md.digest().toHex();
    return final;
}

var displayMessage = function (message, color) {
    var alertBox = $(".advice-box");

    alertBox.html(message);

    if (createNoteAdviceNumber === 0) {
        alertBox.addClass(color + '-box').fadeIn();
        createNoteAdviceNumber++;
    } else {
        alertBox.effect('shake');
        createNoteAdviceNumber++;
    }
}

var hideMessage = function () {
    var alertBox = $(".advice-box");
    alertBox.fadeOut();
}

var encryptContent = function (content) {
    var key = forge.random.getBytesSync(32);
    var iv = forge.random.getBytesSync(32);

    var cipher = forge.cipher.createCipher('AES-CBC', key);

    cipher.start({iv: iv});
    cipher.update(forge.util.createBuffer(content));
    cipher.finish();

    var encrypted = forge.util.encode64(cipher.output.getBytes());

    var result = {
        key: forge.util.encode64(key),
        iv: forge.util.encode64(iv),
        content: encrypted
    };

    return result;
}

var decryptContent = function (content, iv) {

    if (window.location.hash.length === 0) {
        info = prompt("Insert the key:");
    } else {
        info = window.location.hash;
    }

    var key = forge.util.decode64(info.substring(1));
    var iv = forge.util.decode64(iv);
    var decipher = forge.cipher.createDecipher('AES-CBC', key);

    decipher.start({iv: iv});
    decipher.update(forge.util.createBuffer(forge.util.decode64(content)));
    decipher.finish();
    var decipheredText = decipher.output.toString();

    var decoded = $('<textarea/>').html(decipheredText).text();
    $('#note-content').html(decoded);
};

if (typeof escapeHtmlEntities == 'undefined') {
    escapeHtmlEntities = function (text) {
        return text.replace(/[\u00A0-\u2666<>\&]/g, function (c) {
            return '&' +
                (escapeHtmlEntities.entityTable[c.charCodeAt(0)] || '#' + c.charCodeAt(0)) + ';';
        });
    };

    // all HTML4 entities as defined here: http://www.w3.org/TR/html4/sgml/entities.html
    // added: amp, lt, gt, quot and apos
    escapeHtmlEntities.entityTable = {
        34: 'quot',
        38: 'amp',
        39: 'apos',
        60: 'lt',
        62: 'gt',
        160: 'nbsp',
        161: 'iexcl',
        162: 'cent',
        163: 'pound',
        164: 'curren',
        165: 'yen',
        166: 'brvbar',
        167: 'sect',
        168: 'uml',
        169: 'copy',
        170: 'ordf',
        171: 'laquo',
        172: 'not',
        173: 'shy',
        174: 'reg',
        175: 'macr',
        176: 'deg',
        177: 'plusmn',
        178: 'sup2',
        179: 'sup3',
        180: 'acute',
        181: 'micro',
        182: 'para',
        183: 'middot',
        184: 'cedil',
        185: 'sup1',
        186: 'ordm',
        187: 'raquo',
        188: 'frac14',
        189: 'frac12',
        190: 'frac34',
        191: 'iquest',
        192: 'Agrave',
        193: 'Aacute',
        194: 'Acirc',
        195: 'Atilde',
        196: 'Auml',
        197: 'Aring',
        198: 'AElig',
        199: 'Ccedil',
        200: 'Egrave',
        201: 'Eacute',
        202: 'Ecirc',
        203: 'Euml',
        204: 'Igrave',
        205: 'Iacute',
        206: 'Icirc',
        207: 'Iuml',
        208: 'ETH',
        209: 'Ntilde',
        210: 'Ograve',
        211: 'Oacute',
        212: 'Ocirc',
        213: 'Otilde',
        214: 'Ouml',
        215: 'times',
        216: 'Oslash',
        217: 'Ugrave',
        218: 'Uacute',
        219: 'Ucirc',
        220: 'Uuml',
        221: 'Yacute',
        222: 'THORN',
        223: 'szlig',
        224: 'agrave',
        225: 'aacute',
        226: 'acirc',
        227: 'atilde',
        228: 'auml',
        229: 'aring',
        230: 'aelig',
        231: 'ccedil',
        232: 'egrave',
        233: 'eacute',
        234: 'ecirc',
        235: 'euml',
        236: 'igrave',
        237: 'iacute',
        238: 'icirc',
        239: 'iuml',
        240: 'eth',
        241: 'ntilde',
        242: 'ograve',
        243: 'oacute',
        244: 'ocirc',
        245: 'otilde',
        246: 'ouml',
        247: 'divide',
        248: 'oslash',
        249: 'ugrave',
        250: 'uacute',
        251: 'ucirc',
        252: 'uuml',
        253: 'yacute',
        254: 'thorn',
        255: 'yuml',
        402: 'fnof',
        913: 'Alpha',
        914: 'Beta',
        915: 'Gamma',
        916: 'Delta',
        917: 'Epsilon',
        918: 'Zeta',
        919: 'Eta',
        920: 'Theta',
        921: 'Iota',
        922: 'Kappa',
        923: 'Lambda',
        924: 'Mu',
        925: 'Nu',
        926: 'Xi',
        927: 'Omicron',
        928: 'Pi',
        929: 'Rho',
        931: 'Sigma',
        932: 'Tau',
        933: 'Upsilon',
        934: 'Phi',
        935: 'Chi',
        936: 'Psi',
        937: 'Omega',
        945: 'alpha',
        946: 'beta',
        947: 'gamma',
        948: 'delta',
        949: 'epsilon',
        950: 'zeta',
        951: 'eta',
        952: 'theta',
        953: 'iota',
        954: 'kappa',
        955: 'lambda',
        956: 'mu',
        957: 'nu',
        958: 'xi',
        959: 'omicron',
        960: 'pi',
        961: 'rho',
        962: 'sigmaf',
        963: 'sigma',
        964: 'tau',
        965: 'upsilon',
        966: 'phi',
        967: 'chi',
        968: 'psi',
        969: 'omega',
        977: 'thetasym',
        978: 'upsih',
        982: 'piv',
        8226: 'bull',
        8230: 'hellip',
        8242: 'prime',
        8243: 'Prime',
        8254: 'oline',
        8260: 'frasl',
        8472: 'weierp',
        8465: 'image',
        8476: 'real',
        8482: 'trade',
        8501: 'alefsym',
        8592: 'larr',
        8593: 'uarr',
        8594: 'rarr',
        8595: 'darr',
        8596: 'harr',
        8629: 'crarr',
        8656: 'lArr',
        8657: 'uArr',
        8658: 'rArr',
        8659: 'dArr',
        8660: 'hArr',
        8704: 'forall',
        8706: 'part',
        8707: 'exist',
        8709: 'empty',
        8711: 'nabla',
        8712: 'isin',
        8713: 'notin',
        8715: 'ni',
        8719: 'prod',
        8721: 'sum',
        8722: 'minus',
        8727: 'lowast',
        8730: 'radic',
        8733: 'prop',
        8734: 'infin',
        8736: 'ang',
        8743: 'and',
        8744: 'or',
        8745: 'cap',
        8746: 'cup',
        8747: 'int',
        8756: 'there4',
        8764: 'sim',
        8773: 'cong',
        8776: 'asymp',
        8800: 'ne',
        8801: 'equiv',
        8804: 'le',
        8805: 'ge',
        8834: 'sub',
        8835: 'sup',
        8836: 'nsub',
        8838: 'sube',
        8839: 'supe',
        8853: 'oplus',
        8855: 'otimes',
        8869: 'perp',
        8901: 'sdot',
        8968: 'lceil',
        8969: 'rceil',
        8970: 'lfloor',
        8971: 'rfloor',
        9001: 'lang',
        9002: 'rang',
        9674: 'loz',
        9824: 'spades',
        9827: 'clubs',
        9829: 'hearts',
        9830: 'diams',
        338: 'OElig',
        339: 'oelig',
        352: 'Scaron',
        353: 'scaron',
        376: 'Yuml',
        710: 'circ',
        732: 'tilde',
        8194: 'ensp',
        8195: 'emsp',
        8201: 'thinsp',
        8204: 'zwnj',
        8205: 'zwj',
        8206: 'lrm',
        8207: 'rlm',
        8211: 'ndash',
        8212: 'mdash',
        8216: 'lsquo',
        8217: 'rsquo',
        8218: 'sbquo',
        8220: 'ldquo',
        8221: 'rdquo',
        8222: 'bdquo',
        8224: 'dagger',
        8225: 'Dagger',
        8240: 'permil',
        8249: 'lsaquo',
        8250: 'rsaquo',
        8364: 'euro'
    };
}