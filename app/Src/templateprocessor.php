<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/9/009
 * Time: 22:20
 */
namespace PhpOffice\PhpWord;

class TemplateProcessorRe extends TemplateProcessor{
    public function cloneBlock($blockname, $clones = 1, $replace = true)
    {
        $xmlBlock = null;
        preg_match(
            '/(<\?xml.*)(<w:p[\s|>].*>\${' . $blockname . '}<\/w:.*?p>)(.*)(<w:p[\s|>].*\${\/' . $blockname . '}<\/w:.*?p>)/is',
            $this->tempDocumentMainPart,
            $matches
        );
        //dd($matches);
        if (isset($matches[3])) {
            $xmlBlock = $matches[3];
            $cloned = array();
            for ($i = 1; $i <= $clones; $i++) {
                $cloned[] = $xmlBlock;
            }

            if ($replace) {
                $this->tempDocumentMainPart = str_replace(
                    $matches[2] . $matches[3] . $matches[4],
                    implode('', $cloned),
                    $this->tempDocumentMainPart
                );
            }
        }

        return $xmlBlock;
    }

    public function replaceBlock($blockname, $replacement)
    {
        preg_match(
            '/(<\?xml.*)(<w:p[\s|>].*>\${' . $blockname . '}<\/w:.*?p>)(.*)(<w:p[\s|>].*\${\/' . $blockname . '}<\/w:.*?p>)/is',
            $this->tempDocumentMainPart,
            $matches
        );

        if (isset($matches[3])) {
            $this->tempDocumentMainPart = str_replace(
                $matches[2] . $matches[3] . $matches[4],
                $replacement,
                $this->tempDocumentMainPart
            );
        }
    }

    /**
     * Delete a block of text.
     *
     * @param string $blockname
     */
    public function deleteBlock($blockname)
    {
        $this->replaceBlock($blockname, '');
    }

    public function setValueAndColor($search, $replace, $limit = self::MAXIMUM_REPLACEMENTS_DEFAULT)
    {
        if ($replace == 0) {
            return parent::setValue($search,$replace);
        }
        else{
            $pre = '/(<\?xml.*)(<w:color.*\${' . $search . '}[\s\S]*?<\/w:t>)/is';
            preg_match(
                $pre,
                $this->tempDocumentMainPart,
                $matches
            );
            $str = $matches[2];
            $strc = str_replace('000000','FF0000',$str);
            $stra = str_replace('${' . $search . '}',$replace,$strc);

            $this->tempDocumentMainPart = str_replace(
                $matches[2],
                $stra,
                $this->tempDocumentMainPart
            );

            //dd($str,$strc,$stra);
        }


    }
}