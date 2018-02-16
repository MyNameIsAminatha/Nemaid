

<!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Help section</h1>
            </div>

            <!-- /.row -->

<center>
  <br/>
		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span1');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button> </br>
		<B>Why do I have to register to use Nemaid ?</B><br/>
		<span id="span1" style="display:none;" >
		<p  align="justify">
			NEMAID is free but you need to open an account in order to enter your data and save it on your own computer. This allows you to come back later and do some more work on a sample, possibly after changing some of the program parameters. <br/>
			<br/>
		</p>
  </span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span2');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span><br/>
		</button>
		<B>How do I do a straightforward identification ?</B><br/>
		<span id="span2" style="display:none;">
		<p  align="justify">
		To identify one of your unknown populations while accepting the various default options, do the following: <br/>
		1- Select the genus corresponding to your unknown population. <br/>
		2 - Open the tab Your sample, then:  <br/>
		You can describe the origin of the population you want to identify in the table "<B>Sample information</B>". <br/>
		This is optional. <br/>
		Then, enter your sample data in the tables "Quantitative Characters" and “Qualitative characters”. </br>
		You can leave some of the boxes empty. Use means for quantitative characters. For qualitative characters enter the percentage of specimens with each state of the character, using digital percentages (e.g., 0.73 instead of 73%). </br>
		When you are done, click on “Save sample”, then click on “Perform a comparison”. The sample you have just saved will be already selected. </br>
		Click on “Compute Coefficients of similarity”. The results will be displayed </br>
		NEMAID can't help you any further. You must now check the published descriptions of the species at the top of the list and decide if your population belongs in one of them. </br>
		</br>
		</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span3');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>Why are several species given as 100% similar to my sample ?</B><br/>
		<span id="span3" style="display:none;">
		<p  align="justify">
			Unlike dichotomous keys, NEMAID does not give one answer, but a list of possible answers. Depending on the data you entered and the data in the database, NEMAID computes the similarity between your population and all of the species you compared it with. Obviously, the species you are looking for is not one at the bottom of the list. However, your population may be 100% similar to a species according to the characters used in NEMAID but different according to other characters, not used in the Nemaid computations. Therefore, you must look at the complete published descriptions, and possibly at type specimens, before making a final identification. <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span4');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What are the default options and how can I change them ?</B><br/>
		<span id="span4" style="display:none;">
		<p  align="justify">
			<U>Valid / invalid species/descriptions </U><br/>
			By default, Nemaid similarity coefficients are computed only for valid species and, within valid species, only for descriptions that have been accepted as truly representing the species to which they were ascribed. However, you are free to include also the species and populations that are considered as invalid (synonymy, species inquirendae, species transferred to another genus, etc) by later authors.
			In the tab <B>Compute coefficients of similarity</B>, check the box "Include invalid species" <br/><br/>
			<U>Type population, composite descriptions and individual populations</U> <br/>
			By default, Nemaid similarity coefficients are computed for the type population and for a composite description of each species. However, you are free to consider only the type populations (original description), only the composite descriptions, or you can also ask the program to treat individually every description included in the table. In such a case, if species x is represented by, for example, six populations in the data table (its type population and 5 other populations), Nemaid will compute six coefficients of similarity between your sample and species x, one for each of these populations.<br/>
			In the tab <U>Perform a comparison, Type of description</U>, check the radio button of the option you want. <br/>
			<br/>
			<U>Correction factors and weights </U><br/>
			All computation formulae include correction factors and weights for the various characters. <br/>
			Correction factors integrate the variability that can be attributed to each character, as proposed by various authors. Weights relate to the fact that some characters are more reliable than others for identification. You can see the correction factors and weights used by default in the formulae when you enter your sample data. You can then change the default values if you wish. <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span5');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What computation formulae are used in version 3.4 ?</B><br/>
		<span id="span5" style="display:none;" align="justify">
		<p  align="justify">
			Contrary to earlier versions, Nemaid 3 uses a single formula that applies to quantitative and qualitative characters alike. <br/><br/>
			For each population in the species database, quantitative characters are given by the population mean and qualitative characters by the decimal percentage of specimens presenting each state of the character in the population. <br/><br/>
			Every species is represented by its type population and, when it has been redescribed in one or several articles, by its composite description where the value of each character and character state is the mean of that character and state in the various populations of that species that have been described by various authors over the years. <br/><br/>
			Formula 3.1 compares separately the values for each character I and character state ie: <br/><br/>
			For character i, state e, compute: <br/><br/>
			&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp   | Mxie – Msie | - Ci <br/>
			Sie = 1 – ——————— <br/>
			&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Rie – Ci <br/>
			with <br/>
			Sie = score of the character i, state e <br/>
			Mxie = value of character i, state e in the sample <br/>
			Msie = value of character i, state e in a species S (type or composite description) <br/>
			Ci = correction factor for character i (there is only one correction factor per character, even for characters with 2 or more states) <br/>
			Rie = range of the values of character i, state e in the whole genus (maximum value of ie minus minimum value of ie). <br/><br/>
			For the type population, Msie is equal to the value given in line T (this line includes only one value for each state of each character) <br/>
			For the composite populations, Msie is equal to the mean of the values entered in the various populations described under "Species S" <br/><br/>
			Sie is computed for each state e of each character i. Many characters (all the measurements and the "presence/absence" characters) have only 1 state. The others have 2, 3, 4 or possibly more states.<br/><br/>
			When a character has more than one state, the character score S1 is computed by averaging the state values (1, 2, 3, 4 or possibly more values). 	<br/><br/>
			<I>Weighting the scores</I> 		<br/>
			Nemaid multiplies each character score Si by the character weight Wi 	<br/><br/>
			<I>Final coefficient of similarity </I><br/>
			S = å Si Wi / å Wi <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span6');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What are the correction factors included in the Nemaid formulae ?</B><br/>
		<span id="span6" style="display:none;">
		<p  align="justify">
			Nemaid integrates the variability observed for some characters among the species of any given genus. For example, in Helicotylenchus, it has been observed that the body length can vary by up to 150 µm when the progeny of a single parthenogenetic female is raised on different hosts plants (Fortuner, 1984). In the Nemaid formulae, the specific variability is represented by corrections factors and a difference in measurements or percentages between an unknown sample and a species is accepted as indicating a dissimilarity only in so far that such a difference is larger than the correction factor of the corresponding character. <br/>
			If you don’t agree with the default values displayed in the tab “Your samples”, you are free to modify them. <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span7');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What are the weights included in the Nemaid formulae ?</B><br/>
		<span id="span7" style="display:none;">
		<p  align="justify">
			It seems obvious that some characters are more reliable than others. For example, it is generally very easy to measure the body length of a nematode whereas the orifice of the dorsal esophageal gland is often obscure, which means that total body length is more reliable than DGO. In the Nemaid formulae, each character is weighted according to its reliability. <br/>
			If you don’t agree with the default values displayed in the tab “Your samples”, you are free to modify them. You can also chose to set all weights equal to 1, in which case the characters will no longer be weighted. <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span8');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What are the range included in the Nemaid formulae and why can't I change it ?</B><br/>
		<span id="span8" style="display:none;">
			<p  align="justify">
				A character range is the difference between the maximum and minimum values found in the data table for the selected genus. For example, in <I>Helicotylenchus</I>, the largest species (<I>H. coomansi</I>) has a body length of 1235 µm while the smallest species (<I>H. minutus</I>) is 400 µm long. In that genus, the range for body length is 1235-400 = 835 µm. Stylets are far shorter than the whole body and the range for stylet length is only 27 µm. It is even smaller (2) for ratio c’. Ranges are included in the Nemaid formulae in order to compare differences in characters with absolute values so widely different. <br/>
				Ranges are objective values, computed by the program directly from the data in the data table for the selected genus and they cannot be modified by the users. <br/>
				<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span9');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What is a composite description ?</B><br/>
		<span id="span9" style="display:none;">
		<p  align="justify">
			In the database with the descriptions of the species in a genus included in Nemaid, every species is represented at least by its type population (original description). When a species has been redescribed in one or several articles, the program computes its composite description where the value of each character and character state is the mean of that character and state in the various populations of that species as described by various authors over the years. <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span10');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>Why are the composite descriptions missing for some species when I select the option "original and composite description" ?</B><br/>
		<span id="span10" style="display:none;">
			<p  align="justify">
			Composite descriptions are missing for those species that have been described only once (original description) and have not been described by later authors. <br/>
			<br/>
			</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span11');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>What's the meaning of the codes used in the column "Authors" ?</B><br/>
		<span id="span11" style="display:none;">
			In Progress<br/>
			<br/>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span12');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>Will there be more genera available ?</B><br/>
		<span id="span12" style="display:none;">
		<p  align="justify">
			That depends on you and the other users! If you want a particular genus to be entered in the NEMAID list of available genera, please send a message to fortuner@wanadoo.fr. <br/>
		<br/>
		</p>
		</span>

		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="toggle_text('span13');">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</button>
		<B>How do I report an error in the description database ?</B><br/>
		<span id="span13" style="display:none;">
		<p  align="justify">
			You can send a message to fortuner@wanadoo.fr with the exact description of the error <br/>
			<br/>
		</p>
		</span>
  </center>

		<script type="text/javascript">
			function toggle_text(id) {
				var span = document.getElementById(id);
				if(span.style.display == "none") {
					span.style.display = "inline";
				}
				else {
					span.style.display = "none";
				}
			}
		</script> <br>
