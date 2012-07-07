<?php
/**
 * Use this component to compile the LESS file.
 * This component should not be used when in the production mode.
 *
 * Usage:
 *  Yii::app()->lessc->compile($path, $out);
 */
require_once dirname(__FILE__).'/lessphp/lessc.inc.php';
class ZLessCompiler extends CApplicationComponent {
	/**
	 * The include path for the LESS
	 */
    public $importDir = '';

    public function init() {
        $pDir = array();

        // parse the includeDir
        foreach ((array)$this->importDir as $p) {
            $pDir[] = Yii::getPathOfAlias($p);
        }

        $this->importDir = $pDir;
    }

    /**
     * Compile the given file.
     * If will not parse LESS file if the output files is newer than the less file.
     *
     * @param string $in The input path
     * @param string $out The output path
     * @return bool
     */
    public function compile($in, $out) {
        if ( !is_file($out) || filemtime($in)>filemtime($out)) {
            $less = new lessc($in);
            $less->importDir = $this->importDir;
            file_put_contents($out, $less->parse());
            return true;
        }

        return false;
    }
}
