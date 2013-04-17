
        <h2><p>Help</p></h2>
        <ul class="controls">
            <li><a href="#textstyle"><code>STYLE</code></a></li>
            <li><a href="#textlinks"><code>LINK</code></a></li>
            <li><a href="#textlists"><code>LIST</code> & <code>NUMLIST</code></a></li>
            <li><a href="#textimage"><code>IMAGE</code></a></li>
            <li><a href="#textplace"><code>PLACE</code></a></li>
            <li><a href="#textsize"><code>SIZE</code></a></li>
            <li><a href="#textcolor"><code>COLOR</code></a></li>
            <li><a href="#textwidth"><code>WIDTH</code></a></li>
            <li><a href="#textcss"><code>CSS</code></a></li>
        </ul>
        <div id="helppage" class="textarea">
            <p>This page will show you how to add various type of formatting and objects to your posts. Before covering the different formmating tags let's cover how to add formatting to some text. To declare a section of text for formatting you put it in braces and add the appropriate tags like this:</p>
            
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Format Tags</th>
                   <th>Semi-Colon</th>
                   <th>Text</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>b,u</td>
                    <td>;</td>
                    <td>This text would be bold and underlined</td>
                    <td>]</td>
                </tr>
            </table>
            <p>You see that there is a comma seperated list of tags followed by a semi-colon and then the text. This is the general way to add formatting although other tags like <a href="#textlinks" ><code>LINK</code></a> & <a href="#textimage" ><code>IMAGE</code></a> can have modified versions of this. The above text is what you would type directly into the writer page while making a post. So it would look like this, [u;This text would be bold and underlined]. After is is save and displayed on the blog it would show like this, <strong><u>This text would be bold and underlined </u></strong>. Also note that you can nest braces so if you want to achive this, <strong> bold <u>bold and underlined</u> bold</strong>, you can type it like this, [b; bold [u;bold and underlined] bold]. It does not matter if you capitalize the tags.</p>
            <hr />
            <h3 id="textstyle"><a href="#textstyle">Styling</a><a class="toplink" href="#"> - Top</a></h3>
            <p>With these you can add styling such as being bold to your text when you post.</p>
                        
            <p>Here are the avaible tags:</p>
            <ul>
                <li><code>U</code>: <u>Underlines the text</u></li>
                <li><code>B</code>: <strong>Make the text bold</strong></li>
                <li><code>S</code>: <strike>Strikes trough the text</strike></li>
                <li><code>I</code>: <em>Italisizes the text</em></li>
            </ul>
            
            
            <hr />
            <h3 id="textlists"><a href="#textlists">Lists</a><a class="toplink" href="#"> - Top</a></h3>
            <p>Two more formating code aravailble for creating lists. You can use either <code>LIST</code> to use bullets or <code>NUMLIST</code> to use numbers. Example:</p>
            <table>
                <tr>
                   <th><code>LIST</code></th>
                   <th><code>NUMLIST</code></th>
                </tr>
                
                <tr>
                    <td><ul>
                        <li>First line</li>
                        <li>Second line</li>
                        <li>Third line</li>
                    </ul></td>
                    <td><ol>
                        <li>First line</li>
                        <li>Second line</li>
                        <li>Third line</li>
                    </ol></td>
                </tr>
            </table>
            
            <p>Writing this out in the writer would look like this:</p>
            <p><code>[list;</code>First line</p>
            <p>Second line</p>
            <p>Third line<code>]</code></p>
            
            <hr />
            <h3 id="textlinks"><a href="#textlinks">Links</a><a class="toplink" href="#"> - Top</a></h3>
            <p>You can add links to your post with the <code>LINK</code> tag. Unlike the other tags this one can use up to three semi-colons when declaring it. The reason is because you can add a "title" atribute to the link. The title atribute makes text show up on something when you have over it. For example if you hover over <a href="https://www.google.com/" title="A popular search engine">this link</a> title text that describes where it goes apears. You do not have to set title text when you declare a link. Here is how the link tag works using the google link as an example:</p>
            
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Link Tag</th>
                   <th>Semi-Colon</th>
                   <th>URL</th>
                   <th>Semi-Colon</th>
                   <th>Text to show</th>
                   <th>Semi-Colon *Optional</th>
                   <th>Title *Optional</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>link</td>
                    <td>;</td>
                    <td>https://www.google.com/</td>
                    <td>;</td>
                    <td>this link</td>
                    <td>;</td>
                    <td>A popular search engine</td>
                    <td>]</td>
                </tr>
            </table>
            <p>The text that you see as the link is in the middle because you can omit the last semi-colon and the title text.</p>
            
            <hr />
            <h3 id="textimage"><a href="#textimage">Images</a><a class="toplink" href="#"> - Top</a></h3>
            <p>You can add images to your post with the <code>IMAGE</code> tag. Similar to the <a href="#textlinks" ><code>LINK</code></a> tag this one can use up to three semi-colons when declaring it. There is the URL(address) of the image, the alt text, and the title atribute. Like the <a href="#textlinks" ><code>LINK</code></a>, you do not have to set title text when you declare an image. Here is how the image tag looks when using a remote image:</p>
            
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Image Tag</th>
                   <th>Semi-Colon</th>
                   <th>Image URL</th>
                   <th>Semi-Colon</th>
                   <th>Alt Text</th>
                   <th>Semi-Colon *Optional</th>
                   <th>Title *Optional</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>image</td>
                    <td>;</td>
                    <td>http://upload.wikimedia.org/wiki[...]-Intertec_Superbrain.jpg</td>
                    <td>;</td>
                    <td>An old computer</td>
                    <td>;</td>
                    <td>Intertec Superbrain</td>
                    <td>]</td>
                </tr>
            </table>
            <p>The result of that would look like this:</p><img src="http://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Intertec_Superbrain.jpg/287px-Intertec_Superbrain.jpg" alt="An old computer" title="Intertec Superbrain">
            <p>The alt text is what you see if the image doesn't load like this: <img scr="no-image" alt="Image would go here" title="Missing image example.">. It should be a breif description of the image. You may or may not think that the alt text is optional but it is actually invalid HTML to not have is. This is because people who are visualy impaired or have some other form of obstruction that doesn't allow them to see the image need to be able to know what it is. When using this blog tool you must provide an alt text description.</p>
             
            <hr />
            <h3 id="textplace"><a href="#textplace">Placement</a><a class="toplink" href="#"> - Top</a></h3>
            <p>The <code>PLACE</code> lets you add some layout to you post. You can use it to change what side text and images are aligned to and have them be on the sides with text wrapping around them. This tag uses another value to determine wher to place the text or image. Here is the proper format:</p>
            
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Place Tag</th>
                   <th>Semi-Colon</th>
                   <th>Location</th>
                   <th>Semi-Colon</th>
                   <th>Text or <a href="#textimage" ><code>IMAGE</code></a></th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>place</td>
                    <td>;</td>
                    <td>center</td>
                    <td>;</td>
                    <td>This text will be in the center.</td>
                    <td>]</td>
                </tr>
            </table>
            <p> Here are some examples of the two different right values:</p>
            <table>
                <tr>
                   <th><code>RIGHT</code></th>
                   <th><code>WRAPRIGHT</code></th>
                </tr>
                
                <tr>
                    <td class="tablesubheader">Code</td>
                    <td class="tablesubheader">Code</td>
                </tr>
                
                <tr>
                    <td><code>[place;right;This text is aligned to the right.]</code></td>
                    <td><code>[width;em;12;[place;wrapright;This text is wrapped right.]] And this text is not[...]of a column.</code></td>
                </tr>
                
                <tr>
                    <td class="tablesubheader">Result</td>
                    <td class="tablesubheader">Result</td>
                </tr>
                <tr>
                    <td>
                        <p style="text-align: right;">This text is aligned to the right.</p>
                    </td>
                    <td>
                    <p style="float: right;width: 12em;">This text is wrapped right.</p><p>And this text is not, which means that it will flow around the right text and make a pleasent look. Notice how this text wraps under the other text creating the apearance of a column.</p>
                    </td>
                </tr>
            </table>
                        
            <p>Here are the avaible tags:</p>
            <ul>
                <li><code>LEFT</code>: This is the normal behaviour where the text/image aligns to the left.</li>
                <li><code>CENTER</code>: The text/image will be centered</li>
                <li><code>RIGHT</code>: This will make the text/image touch the right on a new line.</li>
                <li><code>WRAPLEFT</code>: This causes the text/image to be stuck to the left. Text not in the braces will wrap around it.</li>
                <li><code>WRAPRIGHT</code>: This causes the text/image to be stuck to the right. Text not in the braces will wrap around it.</li>
            </ul>
            
            <p>It is important to know that when you use <code>WRAPLEFT</code> or <code>WRAPRIGHT</code> the text or image will run off the end of the post if the not wrapped text is not long enough. Here is an example where the blue box represents a post'
            s intended area:</p>
            
            <table>
                <tr>
                   <th>Poor use example</th>
                </tr>
                
                <tr>
                    <td class="tablesubheader">Code</td>
                </tr>
                
                <tr>
                    <td><code>[width;em;12;[place;wrapright;This text is too much text wrapped to the right.]] This is not enought text.</code></td>
                </tr>
                
                <tr>
                    <td class="tablesubheader">Result</td>
                </tr>
                <tr>
                    <td>
                    <div style="border: 1px solid #000000; background: #ccccee;">
                    <p style="float: right;width: 12em;">This text is far too much text wrapped to the right. It will run out of the intended area and will affect the layout of things below it.</p><p>This is not enought text.</p></div>
                    </td>
                </tr>
            </table>
            
            <hr />
            <h3 id="textsize"><a href="#textsize">Size</a><a class="toplink" href="#"> - Top</a></h3>
            <p>With these you can the size of the text. This code takes more than one value. Here is the proper format:</p>
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Size Tag</th>
                   <th>Semi-Colon</th>
                   <th>The Size</th>
                   <th>Semi-Colon</th>
                   <th>Text to show</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>size</td>
                    <td>;</td>
                    <td>big</td>
                    <td>;</td>
                    <td>some big text</td>
                    <td>]</td>
                </tr>
            </table>  
            
            <p>There are five sizes:</p>  
            <ul>
                <li><code>Huge</code>: 4X</li>
                <li><code>Big</code>: 2X</li>
                <li><code>Normal</code>: 1X</li>
                <li><code>Small</code>: 0.5X</li>
                <li><code>Tiny</code>: 0.25X</li>
            </ul>
            
            
            <hr />
            <h3 id="textcolor"><a href="#textcolor">Color</a><a class="toplink" href="#"> - Top</a></h3>
            <p>With these you can add some color to your post. This tag uses an extra value so you can set the color. Here is the proper format:</p>
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Color Tag</th>
                   <th>Semi-Colon</th>
                   <th>The Color</th>
                   <th>Semi-Colon</th>
                   <th>Text to show</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>color</td>
                    <td>;</td>
                    <td>red</td>
                    <td>;</td>
                    <td>some big text</td>
                    <td>]</td>
                </tr>
            </table>  
                        
            <p>Here are the avaible colors:</p>
            <ul>
                <li><code style="color: #ff0000;">RED</code></li>
                <li><code style="color: #00ff00;">GREEN</code></li>
                <li><code style="color: #0000ff;">BLUE</code></li>
                <li><code style="color: #ffff00;">YELLOW</code></li>
                <li><code style="color: #00ffff;">CYAN</code></li>
                <li><code style="color: #ff00ff;">PURPLE</code></li>
            </ul>
            <p>You can also specify a custom color in the color area using HTML format codes such as <code>#333333</code> for dark grey. You can also use the "colour" spelling when declaring the tag.</p>
            
            
            <hr />
            <h3 id="textwidth"><a href="#textwidth">Width</a><a class="toplink" href="#"> - Top</a></h3>
            <p>This <code>WIDTH</code> code lets you define a set width for an image or block of text. This is mostly usefull when used with the <a href="#textimage" ><code>IMAGE</code></a> & <a href="#textplace" ><code>PLACE</code></a> codes. When you declare the tag you will also declare two other values, the unit of measurement, and the amount. Here is the proper format:</p>
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Width Tag</th>
                   <th>Semi-Colon</th>
                   <th>The Unit</th>
                   <th>Semi-Colon</th>
                   <th>The Amount</th>
                   <th>Semi-Colon</th>
                   <th>Text to show</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>width</td>
                    <td>;</td>
                    <td>pixels</td>
                    <td>;</td>
                    <td>300</td>
                    <td>;</td>
                    <td>some text</td>
                    <td>]</td>
                </tr>
            </table>  
                        
            <p>Here are the avaible unit tags:</p>
            <ul>
                <li><code>CHAR</code> & <code>EM</code>: The width of a letter "M".</li>
                <li><code>PIXELS</code> & <code>PX</code>: The width of one pixel at no zoom.</li>
                <li><code>PERCENT</code> & <code>%</code>: A percentage of the total width of the area.</li>
            </ul>
            
            <hr />
            <h3 id="textcss"><a href="#textcss">CSS</a><a class="toplink" href="#"> - Top</a></h3>
            <p>The <code>CSS</code> tag lets you use straight CSS styling by putting text in a div with inline styling. Put the desired styles in the styles field with comma seeprators.:</p>
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>CSS Tag</th>
                   <th>Semi-Colon</th>
                   <th>Styles</th>
                   <th>Semi-Colon</th>
                   <th>Text to show</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>css</td>
                    <td>;</td>
                    <td>background: #eecccc</td>
                    <td>;</td>
                    <td>some text with a red background</td>
                    <td>]</td>
                </tr>
            </table>  
                                    
            
            <hr />
            <h3 id="contact"><a href="#contact">Contact</a><a class="toplink" href="#"> - Top</a></h3>
            <p>If you have any questions, comment, concerns, idea, bug reports, etc please email the developer at <a href="mailto:shelbyjueden@gmail.com">shelbyjueden@gmail.com</a> and I will try to get back to you as quickly as possible.</p>
        </div>
