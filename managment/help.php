        <div id="helppage" class="textarea">
            <h2>Help</h2>
            <hr />
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
            <h3 id="textstyle"><a href="#textstyle">Styling</a></h3>
            <p>With these you can add styling such as being bold to your text when you post.</p>
                        
            <p>Here are the avaible tags:</p>
            <ul>
                <li>U: <u>Underlines the text</u></li>
                <li>B: <strong>Make the text bold</strong></li>
                <li>S: <strike>Strikes trough the text</strike></li>
                <li>I: <em>Italisizes the text</em></li>
            </ul>
            
            
            <h3 id="textlists"><a href="#textlists">Lists</a></h3>
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
            <p>[list;First line</p>
            <p>Second line</p>
            <p>Third line]</p>
            
            <h3 id="textlinks"><a href="#textlinks">Links</a></h3>
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
            
            <h3 id="textimage"><a href="#textimage">Images</a></h3>
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
                    <td>http://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Intertec_Superbrain.jpg/287px-Intertec_Superbrain.jpg</td>
                    <td>;</td>
                    <td>An old computer</td>
                    <td>;</td>
                    <td>Intertec Superbrain</td>
                    <td>]</td>
                </tr>
            </table>
            <p>The result of that would look like this:</p><img src="http://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Intertec_Superbrain.jpg/287px-Intertec_Superbrain.jpg" alt="An old computer" title="Intertec Superbrain">
            <p>The alt text is what you see if the image doesn't load like this: <img scr="no-image" alt="Image would go here" title="Missing image example.">. It should be a breif description of the image. You may or may not think that the alt text is optional but it is actually invalid HTML to not have is. This is because people who are visualy impaired or have some other form of obstruction that doesn't allow them to see the image need to be able to know what it is. When using this blog tool you must provide an alt text description.</p>
            
            <h3 id="contact"><a href="#contact">Contact</a></h3>
            <p>If you have any questions, comment, concerns, idea, bug reports, etc please email the developer at <a href="mailto:shelbyjueden@gmail.com">shelbyjueden@gmail.com</a> and I will try to get back to you as quickly as possible.</p>
        </div>
