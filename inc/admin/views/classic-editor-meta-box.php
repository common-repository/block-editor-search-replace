<div class="besnr-admin">
	<div class="besnr-form-ui">
		<p>
			<?php echo esc_html__( 'The search and replace plugin will help you find any text inside the Classic Editor content area and change with the replacement value.', 'block-editor-search-replace' ); ?>
		</p>
		<form id="besnr-form" name="besnr-form" type="post">
			<div class="besnr-loading-bar"></div>
			<div id="besnr-output" class="besnr-output"></div>
			<input 
				type="hidden" 
				id="besnr-current-post-type"
				name="besnr-current-post-type" 
				value="<?php echo esc_attr( $post->post_type ); ?>"
			/>
			<input 
				type="hidden" 
				id="besnr-current-post-id" 
				name="besnr-current-post-id" 
				value="<?php echo esc_attr( $post->ID ); ?>"
			/>
			<input
				type="hidden" 
				id="besnr-classic-editor"
				name="besnr-classic-editor" 
				value="1"
			/>
			<div class="search-replace-group">
				<p>
					<label for="besnr-highlight-search">
						<input
							type="checkbox" 
							id="besnr-highlight-search" 
							name="besnr-highlight-search" 
							checked
						/>
						<span>
							<?php echo esc_html__( 'Highlight text on search', 'block-editor-search-replace' ); ?>
						</span>
					</label>
				</p>
				<p>
					<label for="besnr-case-sensitive">
						<input
							type="checkbox" 
							id="besnr-case-sensitive" 
							name="besnr-case-sensitive"
							checked
						/>
						<span>
							<?php echo esc_html__( 'Case sensitive search & replace', 'block-editor-search-replace' ); ?>
						</span>
					</label>
				</p>
				<p>
					<input 
						type="text" 
						id="besnr-search-phrase" 
						name="besnr-search-phrase"  
						class="besnr-search-phrase" 
						value="" 
						placeholder="<?php echo esc_html__( 'Enter you search phrase...', 'block-editor-search-replace' ); ?>" 
					/>
				</p>
				<p>
					<input 
						type="text" 
						id="besnr-replace-with-phrase" 
						name="besnr-replace-with-phrase" 
						class="besnr-replace-with-phrase" 
						value="" 
						placeholder="<?php echo esc_html__( 'Enter your replace with phrase...', 'block-editor-search-replace' ); ?>" 
					/>
				</p>
				<p class="button-group">
					<button 
						id="besnr-search-replace"
						name="besnr-search-replace" 
						class="button button-primary besnr-search-replace"
					>
						<i class="dashicons dashicons-randomize"></i>
						<?php echo esc_html__( 'Replace', 'block-editor-search-replace' ); ?>
					</button>
					<button 
						id="besnr-clean-tags"
						name="besnr-clean-tags" 
						class="button besnr-clean-tags"
					>
						<?php echo esc_html__( 'Reset', 'block-editor-search-replace' ); ?>
					</button>
				</p>
			</div>
		</form>
	</div>
</div>
