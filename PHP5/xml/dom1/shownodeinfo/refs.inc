<?php ## ‘ункци€ формировани€ адреса страницы отображени€ узла
/**
 * —формировать тропу до родительского элемента
 *
 * @return string тропа, указывающа€ родительский элемент
 */
function ParentRef()
{
    global $path; //тропа до отображаемого узла
    $nodepath=$path;
    $n=strrpos($path,'/');  //позици€ последнего символа /
    if ($n >= 0)
	$nodepath=substr($path,0,$n);
    return ($nodepath);
}

/**
 * —формировать тропу до следующего узла
 *
 * @return string тропа, указывающа€ следующий узел
 */
function NextSiblingRef()
{
    global $path; //тропа до отображаемого узла
    $nodepath=$path;
    $n=strrpos($path,'/');  //позици€ последнего символа /
    if ($n >= 0) {
	$n++;
	if (substr($path,$n,1)=='@') $n++; //узел атрибута
	$parentpath=substr($path,0,$n);     //путь до родител€
	$local=substr($path,$n);  //номер в уровне
	$nodepath="$parentpath".($local+1);
    }
    return ($nodepath);
}

/**
 * —формировать тропу до предыдущего узла
 *
 * @return string тропа, указывающа€ предыдущий узел
 */
function PreviousSiblingRef() {
    global $path; //тропа до отображаемого узла
    $n=strrpos($path,'/');  //позици€ последнего символа /
    $nodepath=$path;
    if ($n >= 0) {
	$n++;
	if (substr($path,$n,1)=='@') $n++; //узел атрибута
	$parentpath=substr($path,0,$n);     //путь до родител€
	$local=substr($path,$n);  //номер в уровне
	$nodepath="$parentpath".($local-1);
    }
    return ($nodepath);
}

/**
 * —формировать тропу до первого дочернего элемента
 *
 * @return string тропа, указывающа€ первый дочерний элемент
 */
function FirstChildRef()
{
    global $path; //тропа до отображаемого узла
    $nodepath=$path;
    $nodepath.="/1";
    return ($nodepath);
}

/**
 * —формировать тропу до последнего дочернего элемента
 *
 * @param int $nlast номер последнего дочернего элемента
 *
 * @return string тропа, указывающа€ последний дочерний элемент
 */
function LastChildRef($nlast)
{
    global $path; //тропа до отображаемого узла
    $nodepath=$path;
    $nodepath.="/$nlast";
    return ($nodepath);
}

/**
 * —формировать тропу до дочернего элемента $num
 *
 * @param int $num номер дочернего узла
 *
 * @return string тропа, указывающа€ дочерний элемент $num
 */
function ChildRef($num)
{
    global $path; //тропа до отображаемого узла
    $nodepath="$path/".($num+1); //0-й элемент адресуетс€ как 1-й
    return ($nodepath);
}

/**
 * —формировать тропу до атрибута $num
 *
 * @param int $num номер атрибута
 *
 * @return string тропа, указывающа€ на атрибут $num
 */
function AttrRef($num)
{
    global $path; //тропа до отображаемого узла
    $nodepath="$path/@".($num+1);
    return ($nodepath);
}
?>
