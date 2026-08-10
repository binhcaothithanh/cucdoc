<div class="form_default">
    <div class="seo">
        <fieldset class="largeframe">
            <legend>SEO</legend>         
            <div class="row_seo">
                <label>Snippet Preview</label>
                <div id="wpseosnippet">
                    <a class="title" id="wpseosnippet_title" href="#">  - Default title</a>
                    <span class="url"><?php echo URL_FONTEND; ?>/</span>
                    <p class="desc"><span class="autogen"></span><span class="content"></span></p>
                </div>
            </div>
            <div class="row_seo">
                <label>Focus Keyword:</label>
                <input value="<?php echo @$result['focus_keyword']; ?>"  name="focus_keyword"/>
                <div style="margin-left: 170px;">
                    <div style="display: none;" id="focuskwresults">
                        <p>Your focus keyword was found in:</p>
                        <ul>
                            <li>Article Heading: <span></span></li>
                            <li>Page title: <span></span></li>
                            <li>Content: <span></span></li>
                            <li>Meta description: <span></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row_seo">
                <label>SEO Title:</label>
                <input  value="<?php echo @$result['seo_title']; ?>" name="seo_title"/>
            </div>
            <div class="row_seo">
                <label>Meta keyword:</label>
                <input value="<?php echo @$result['meta_keyword']; ?>" name="meta_keyword"/>
            </div>
            <div class="row_seo">
                <label>Meta Description:</label>
                <textarea style="height: 100px;" name="meta_description"><?php echo @$result['meta_description']; ?></textarea><br/>
                <label>&nbsp;</label>
                The meta description will be limited to 156 chars, chars left.
            </div>
        </fieldset>
    </div>

</div>
<script src="/assets/admin/js/seo.js"></script>