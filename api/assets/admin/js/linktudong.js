
function array_char(kytu_thaythe) {
    var kytu_tim = kytu_thaythe;
    var kytu_mang = new Array(new Array("ấ", "ầ", "ẩ", "ẫ", "ậ", "Ấ", "Ầ", "Ẩ", "Ẫ", "Ậ", "ắ", "ằ", "ẳ", "ẵ", "ặ", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ", "á", "à", "ả", "ã", "ạ", "â", "ă", "Á", "À", "Ả", "Ã", "Ạ", "Â", "Ă"), new Array("ế", "ề", "ể", "ễ", "ệ", "Ế", "Ề", "Ể", "Ễ", "Ệ", "é", "è", "ẻ", "ẽ", "ẹ", "ê", "É", "È", "Ẻ", "Ẽ", "Ẹ", "Ê"), new Array("í", "ì", "ỉ", "ĩ", "ị", "Í", "Ì", "Ỉ", "Ĩ", "Ị"), new Array("ố", "ồ", "ổ", "ỗ", "ộ", "Ố", "Ồ", "Ổ", "Ô", "Ộ", "ớ", "ờ", "ở", "ỡ", "ợ", "Ớ", "Ờ", "Ở", "Ỡ", "Ợ", "ó", "ò", "ỏ", "õ", "ọ", "ô", "ơ", "Ó", "Ò", "Ỏ", "Õ", "Ọ", "Ô", "Ơ"), new Array("ứ", "ừ", "ử", "ữ", "ự", "Ứ", "Ừ", "Ử", "Ữ", "Ự", "ú", "ù", "ủ", "ũ", "ụ", "ư", "Ú", "Ù", "Ủ", "Ũ", "Ụ", "Ư"), new Array("ý", "ỳ", "ỷ", "ỹ", "ỵ", "Ý", "Ỳ", "Ỷ", "Ỹ", "Ỵ"), new Array("đ", "Đ"), new Array("?",'`', "~", ";", "+", "=", "*", "!", "#", "%", "^", "'", ".", "/", "\\", "\"", "\,", ":", "[", "]", "{", "}", "\(", "\)", "@", "&", "$", "|", "<", ">"));
    for (var i = 0; i < kytu_mang.length; i++) {
        for (var j = 0; j < kytu_mang[i].length; j++) {
            if (kytu_tim == kytu_mang[i][j]) {
                //1-a,2-e,3-i,4-o,5-u,6-y,7-d
                switch (i) {
                    case 0:
                        kytu_tim = "a";
                        break;
                    case 1:
                        kytu_tim = "e";
                        break;
                    case 2:
                        kytu_tim = "i";
                        break;
                    case 3:
                        kytu_tim = "o";
                        break;
                    case 4:
                        kytu_tim = "u";
                        break;
                    case 5:
                        kytu_tim = "y";
                        break;
                    case 6:
                        kytu_tim = "d";
                        break;
                    case 7:
                        kytu_tim = "";
                        break;
                }
                return kytu_tim;
            }

        }
    }
    return kytu_tim;
}

function remove_special_char(text_nhap){
    var kytu_mang = new Array("?","`", "~", ";", "+", "=", "*", "!", "#", "%", "^", "'", ".", "/", "\\", "\"", "\,", "-", ":", "[", "]", "{", "}", "\(", "\)", "@", "&", "$", "|", "<", ">");
     var len_char = text_nhap.length;
     var abc = '';
      for (var j =0; j < len_char; j++) {
          if(kytu_mang.indexOf(text_nhap[j]) > -1){              
          }else{             
              abc+=text_nhap[j];
          }
      }
      return abc;
}

function array_char2(kytu_nhap) {
    var kytu_tim = kytu_nhap;
    var kytu_mang = new Array("?","`", "~", ";", "+", "=", "*", "!", "#", "%", "^", "'", ".", "/", "\\", "\"", "\,", "-", ":", "[", "]", "{", "}", "\(", "\)", "@", "&", "$", "|", "<", ">");
    for (var j = 0; j < kytu_mang.length; j++) {
        if (kytu_tim == kytu_mang[j]) {            
            return "";
        }
    }
    
    return kytu_nhap;
}


function taolink(from,to)
{
    var text_nhap = document.getElementById(from).value;
    var len_char = text_nhap.length;
    var text_ketqua = '';
    var text_ketqua2 = '';
    var text_nhap2 = text_nhap;
    var text_kytu = '';
    var text_kytu2 = '';
    var khoangtrang = 1;
    for (var j = len_char - 1; j >= 0; j--) {
        if (text_nhap.charAt(j) == ' ') {
            text_nhap2 = text_nhap.substring(0, j);
        }
        else {
            break;
        }
    }

    len_char2 = text_nhap2.length;
    //TU dong link
    for (var i = 0; i < len_char2; i++) {
        var text_kytu = text_nhap2.charAt(i);
        if (text_kytu == ' ')
        {
            text_kytu = '-';
            khoangtrang += 1;
            if (khoangtrang == 2) {
                text_kytu2 = ' ';
                khoangtrang = 0;
            }
            else
            {
                text_kytu2 = ',';
            }
        }
        else {
            
            text_kytu2 = array_char2(text_kytu);         
            text_kytu = array_char(text_kytu);
        }

        text_ketqua += text_kytu;
        text_ketqua2 += text_kytu2;

        text_ketqua = text_ketqua.replace("--", "-");
    }
    var dodaiketqua;
    dodaiketgqua = text_ketqua.length;
    for (h = dodaiketgqua - 1; h >= 0; h--) {
        if (text_ketqua.charAt(h) == "-")
        {
            text_ketqua = text_ketqua.substring(0, h);
        }
        else
            break;
    }

    var dodaiketqua2;
    dodaiketgqua2 = text_ketqua2.length;
    for (h2 = dodaiketgqua2 - 1; h2 >= 0; h2--) {
        if (text_ketqua2.charAt(h2) == "-" || text_ketqua2.charAt(h2) == "_")
        {
            text_ketqua2 = text_ketqua2.substring(0, h2);
        }
        else
            break;
    }
    //Tu dong Tag   
    document.getElementById(to).value = text_ketqua;
    //document.getElementById('tag').value = text_ketqua2;
}