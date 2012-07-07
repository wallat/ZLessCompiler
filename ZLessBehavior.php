<?php
/**
 * Register the behaviors into the whole app
 */
class ZLessBehavior extends CBehavior {
    /**
     * Declares events and the corresponding event handler methods.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events() {
        if (YII_DEBUG && !property_exists(Yii::app(), 'commandMap')) {
            return array(
                'onEndRequest'=>'endRequest',
            );
        }

        return array();
    }

    /**
     * Actions to take before doing the request.
     */
    public function endRequest() {
        // traverse all the public asset directory
        $assetPath = Yii::app()->getAssetManager()->getBasePath();
        $this->compileFolder($assetPath);
    }

    /**
     * Compile all the less file inside the folder
     *
     * @param string $path
     */
    public function compileFolder($dir) {
        $handle = opendir($dir);
        while (($file=readdir($handle))!==false) {
            if ($file==='.' || $file==='..') {
                continue;
            }

            $path=$dir.DIRECTORY_SEPARATOR.$file;

            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if ($ext=='less') {
                    $out = preg_replace('/\.less$/', '.css', $path);

                    Yii::app()->lessc->compile($path, $out);
                }
            } else if (is_dir($path)) {
                $this->compileFolder($path);
            }
        }
    }
}
