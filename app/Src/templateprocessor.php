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
}