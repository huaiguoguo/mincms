/**
* check password , strong... 
*
<input class="txt_input" id='password' onkeyup="pwStrength(this.value)"  type="password" />
<ul>
	<li id='strength_L'><a href="#">��</a></li>
	<li id='strength_M' ><a href="#">��</a></li>
	<li class="shuoa_b" id='strength_H'><a>ǿ</a></li>
</ul>
*
*/

//����ǿ��
//�ж��������������
function CharMode(iN) {
	if (iN >= 48 && iN <= 57) //����
	return 1;
	if (iN >= 65 && iN <= 90) //��д
	return 2;
	if (iN >= 97 && iN <= 122) //Сд
	return 4;
	else return 8;
} //bitTotal����
//��������ģʽ
function bitTotal(num) {
	modes = 0;
	for (i = 0; i < 4; i++) {
		if (num & 1) modes++;
		num >>>= 1;
	}
	return modes;
} //����ǿ�ȼ���
function checkStrong(sPW) {
	if (sPW.length <= 4) return 0; //����̫��
	Modes = 0;
	for (i = 0; i < sPW.length; i++) { //����ģʽ
		Modes |= CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
} //��ʾ��ɫ
function pwStrength(pwd) {
	O_color = "#eeeeee";
	L_color = "#FF0000";
	M_color = "#FF9900";
	H_color = "#33CC00";
	if (pwd == null || pwd == '') {
		Lcolor = Mcolor = Hcolor = O_color;
	} else {
		S_level = checkStrong(pwd);
		switch (S_level) {
		case 0:
			Lcolor = Mcolor = Hcolor = O_color;
		case 1:
			Lcolor = L_color;
			Mcolor = Hcolor = O_color;
			break;
		case 2:
			Lcolor = Mcolor = M_color;
			Hcolor = O_color;
			break;
		default:
			Lcolor = Mcolor = Hcolor = H_color;
		}
	}
	document.getElementById("strength_L").style.background = Lcolor;
	document.getElementById("strength_M").style.background = Mcolor;
	document.getElementById("strength_H").style.background = Hcolor;
	return;
}