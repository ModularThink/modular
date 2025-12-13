<template>
    <div>
        <div
            class="border-neutral-7 mx-0 mt-1 mb-0 flex flex-none flex-wrap items-center rounded-t-md border-x border-t border-solid bg-no-repeat p-2 font-sans text-xl leading-5 tracking-normal break-words"
            :class="editorClass"
        >
            <TipTapButton
                :title="__('Bold')"
                icon="ri-bold"
                @click.prevent="editor.commands.toggleBold()"
            />

            <TipTapButton
                :title="__('Italic')"
                icon="ri-italic"
                @click.prevent="editor.commands.toggleItalic()"
            />

            <TipTapButton
                :title="__('Underline')"
                icon="ri-underline"
                @click.prevent="editor.commands.toggleUnderline()"
            />

            <TipTapButton
                :title="__('Strikethrough')"
                icon="ri-strikethrough"
                @click.prevent="editor.commands.toggleStrike()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Heading 1')"
                icon="ri-h-1"
                @click.prevent="editor.commands.toggleHeading({ level: 1 })"
            />

            <TipTapButton
                :title="__('Heading 2')"
                icon="ri-h-2"
                @click.prevent="editor.commands.toggleHeading({ level: 2 })"
            />

            <TipTapButton
                :title="__('Heading 3')"
                icon="ri-h-3"
                @click.prevent="editor.commands.toggleHeading({ level: 3 })"
            />

            <TipTapButton
                :title="__('Heading 4')"
                icon="ri-h-4"
                @click.prevent="editor.commands.toggleHeading({ level: 4 })"
            />

            <TipTapButton
                :title="__('Paragraph')"
                icon="ri-paragraph"
                @click.prevent="editor.commands.setParagraph()"
            />

            <TipTapButton
                :title="__('List')"
                icon="ri-list-unordered"
                @click.prevent="editor.commands.toggleBulletList()"
            />

            <TipTapButton
                :title="__('Ordered Link')"
                icon="ri-list-ordered"
                @click.prevent="editor.commands.toggleOrderedList()"
            />

            <TipTapButton
                :title="__('Add Link')"
                icon="ri-link-m"
                @click.prevent="setLink"
            />

            <TipTapButton
                :title="__('Remove Link')"
                icon="ri-link-unlink-m"
                @click.prevent="editor.commands.unsetLink()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Line Break')"
                icon="ri-text-wrap"
                @click.prevent="editor.commands.setHardBreak()"
            />

            <TipTapButton
                :title="__('Horizontal Rule')"
                icon="ri-separator"
                @click.prevent="editor.commands.setHorizontalRule()"
            />

            <TipTapButton
                :title="__('Clear Format')"
                icon="ri-format-clear"
                @click.prevent="editor.commands.clearNodes()"
            />

            <TipTapDivider />

            <TipTapButton
                v-if="fileUploadUrl"
                :title="__('Add Image')"
                icon="ri-image-add-line"
                @click.prevent="uploadFile"
            />

            <TipTapButton
                :title="__('Add Video')"
                icon="ri-youtube-line"
                @click.prevent="addVideo"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Table')"
                icon="ri-table-line"
                @click.prevent="toggleTableToolbar"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Undo')"
                icon="ri-arrow-go-back-line"
                @click.prevent="editor.commands.undo()"
            />

            <TipTapButton
                :title="__('Redo')"
                icon="ri-arrow-go-forward-line"
                @click.prevent="editor.commands.redo()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Code View')"
                icon="ri-code-box-line"
                @click.prevent="changeEditorMode"
            />
        </div>

        <div
            v-show="showTableToolbar"
            class="border-neutral-7 border-t-neutral-7 mx-0 mb-0 flex flex-none flex-wrap items-center border-x border-t border-solid bg-no-repeat p-2 font-sans text-xl leading-5 tracking-normal break-words"
        >
            <TipTapButton
                :title="__('Insert Table')"
                icon="ri-table-2"
                @click.prevent="
                    editor.commands.insertTable({
                        rows: 3,
                        cols: 3,
                        withHeaderRow: true
                    })
                "
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Add Column Before')"
                icon="ri-layout-3-line"
                @click.prevent="editor.commands.addColumnBefore()"
            />

            <TipTapButton
                :title="__('Add Column After')"
                icon="ri-layout-6-line"
                @click.prevent="editor.commands.addColumnAfter()"
            />

            <TipTapButton
                :title="__('Delete Column')"
                icon="ri-delete-column"
                @click.prevent="editor.commands.deleteColumn()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Add Row Before')"
                icon="ri-insert-row-top"
                @click.prevent="editor.commands.addRowBefore()"
            />

            <TipTapButton
                :title="__('Add Row After')"
                icon="ri-insert-row-bottom"
                @click.prevent="editor.commands.addRowAfter()"
            />

            <TipTapButton
                :title="__('Delete Row')"
                icon="ri-delete-row"
                @click.prevent="editor.commands.deleteRow()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Merge Cells')"
                icon="ri-merge-cells-horizontal"
                @click.prevent="editor.commands.mergeCells()"
            />

            <TipTapButton
                :title="__('Split Cell')"
                icon="ri-split-cells-horizontal"
                @click.prevent="editor.commands.splitCell()"
            />

            <TipTapButton
                :title="__('Alternate Column Header')"
                icon="ri-archive-drawer-line"
                @click.prevent="editor.commands.toggleHeaderColumn()"
            />

            <TipTapButton
                :title="__('Alternate Row Header')"
                icon="ri-archive-drawer-fill"
                @click.prevent="editor.commands.toggleHeaderRow()"
            />

            <TipTapButton
                :title="__('Alternate Cell Header')"
                icon="ri-split-cells-vertical"
                @click.prevent="editor.commands.toggleHeaderCell()"
            />

            <TipTapButton
                :title="__('Merge or Split')"
                icon="ri-merge-cells-vertical"
                @click.prevent="editor.commands.mergeOrSplit()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Go to Next Cell')"
                icon="ri-arrow-right-s-line"
                @click.prevent="editor.chain().focus().goToNextCell().run()"
            />

            <TipTapButton
                :title="__('Go to Previous Cell')"
                icon="ri-arrow-left-s-line"
                @click.prevent="editor.chain().focus().goToPreviousCell().run()"
            />

            <TipTapDivider />

            <TipTapButton
                :title="__('Fix Table')"
                icon="ri-settings-line"
                @click.prevent="editor.commands.fixTables()"
            />

            <TipTapButton
                :title="__('Delete Table')"
                icon="ri-delete-bin-2-line"
                @click.prevent="editor.commands.deleteTable()"
            />
        </div>
        <editor-content
            v-show="!codeMode"
            :editor="editor"
            class="border-neutral-7 relative m-0 max-h-[240px] min-h-[120px] overflow-auto rounded-b-md border border-solid bg-no-repeat px-1 py-1 font-sans text-xs leading-5 tracking-normal break-words"
        />

        <textarea
            v-show="codeMode"
            :id="editorId"
            v-model="htmlContent"
            class="border-neutral-7 bg-neutral-1 min-h-[240px] w-full rounded-b-md border border-solid font-sans text-xs leading-5 tracking-normal"
            @input="syncEditor"
        >
        </textarea>
    </div>
</template>

<script setup>
import { ref, onBeforeUnmount } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Youtube from '@tiptap/extension-youtube'
import { Table, TableCell, TableHeader, TableRow } from '@tiptap/extension-table'
import TipTapButton from './TipTap/TipTapButton.vue'
import TipTapDivider from './TipTap/TipTapDivider.vue'

import FileUpload from './TipTap/extension-file-upload.js'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    editorId: {
        type: String,
        default: ''
    },
    editorClass: {
        type: String,
        default: ''
    },
    fileUploadUrl: {
        type: [String, Boolean],
        default: false
    },
    allowedFileTypes: {
        type: String,
        default: 'image/*'
    }
})

const codeMode = ref(false)
const htmlContent = ref('')

const syncEditor = () => {
    emit('update:modelValue', htmlContent.value)
}

const changeEditorMode = () => {
    codeMode.value = !codeMode.value

    if (codeMode.value) {
        htmlContent.value = editor.value.getHTML()
    } else {
        editor.value.commands.setContent(htmlContent.value)
        emit('update:modelValue', htmlContent.value)
    }
}

const uploadFile = () => {
    editor.value.chain().focus().uploadFile().run()
}

const emit = defineEmits(['update:modelValue'])

const showTableToolbar = ref(false)

const onBeforeUpload = (request) => {
    request.formData.append(
        '_token',
        document
            .querySelector("meta[name='csrf-token']")
            .getAttribute('content')
    )
}

const onUploadCompleted = (event, editor) => {
    const data = JSON.parse(event.target.response)
    editor
        .chain()
        .setImage({
            src: data.fileUrl,
            alt: data.readableName,
            title: data.readableName
        })
        .run()
}

const onError = (errorMessage) => {
    console.error(errorMessage)
}

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit.configure({
            link: {
                openOnClick: false
            }
        }),
        Image.configure({
            inline: false
        }),
        Youtube.configure({
            controls: false
        }),
        Table.configure({
            resizable: true
        }),
        TableRow,
        TableHeader,
        TableCell,
        FileUpload.configure({
            allowedFileTypes: props.allowedFileTypes,
            maximumFileSize: 5,
            onBeforeUpload: onBeforeUpload,
            onUploadCompleted: onUploadCompleted,
            onError: onError,
            fileUploadUrl: props.fileUploadUrl
        })
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML())
    }
})

onBeforeUnmount(() => {
    editor.value.destroy()
})

const toggleTableToolbar = () => {
    showTableToolbar.value = !showTableToolbar.value
}

const setLink = () => {
    const previousUrl = editor.value.getAttributes('link').href
    const url = window.prompt('URL', previousUrl)
    // cancelled
    if (url === null) {
        return
    }
    // empty
    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run()
        return
    }
    // update link
    editor.value
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run()
}

const addVideo = () => {
    const url = window.prompt('Enter YouTube URL')

    if (!url) {
        return
    }

    editor.value.commands.setYoutubeVideo({
        src: url,
        width: 640,
        height: 480
    })
}
</script>

<style>
@reference "../../../css/app.css";

.app-tip-tap-error {
    border: 1px solid theme('colors.error.DEFAULT');
    border-radius: 3px;
}

.ProseMirror {
    min-height: 120px;
    padding: 5px 10px;
    background-color: theme('colors.neutral.1');
}

.ProseMirror p {
    margin: 1em 0;
}

.ProseMirror a {
    text-decoration: underline;
    color: theme('colors.primary.11');
}

/* Heading Sizes, See: https://tailwindcss.com/docs/font-size */

.ProseMirror h1 {
    font-size: 2.25rem; /* 36px */
    line-height: 2.5rem; /* 40px */
}

.ProseMirror h2 {
    font-size: 1.875rem; /* 30px */
    line-height: 2.25rem; /* 36px */
}

.ProseMirror h3 {
    font-size: 1.5rem; /* 24px */
    line-height: 2rem; /* 32px */
}

.ProseMirror h4 {
    font-size: 1.25rem; /* 20px */
    line-height: 1.75rem; /* 28px */
}

.ProseMirror ul {
    display: block;
    list-style-type: disc;
    padding-left: 0.8rem;
}

.ProseMirror ul li {
    display: list-item;
}

.ProseMirror ol {
    display: block;
    list-style: decimal;
    padding-left: 0.8rem;
}

.ProseMirror table {
    border-collapse: collapse;
    table-layout: fixed;
    width: 100%;
    margin: 0;
    overflow: hidden;
}

.ProseMirror table td,
.ProseMirror table th {
    min-width: 1em;
    border: 2px solid theme('colors.neutral.6');
    padding: 3px 5px;
    vertical-align: top;
    box-sizing: border-box;
    position: relative;
}

.ProseMirror table th > * {
    margin-bottom: 0;
}

.ProseMirror th {
    font-weight: bold;
    text-align: left;
    background-color: theme('colors.neutral.2');
}

.ProseMirror .selectedCell:after {
    z-index: 2;
    position: absolute;
    content: '';
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: rgba(200, 200, 255, 0.4);
    pointer-events: none;
}

.ProseMirror .column-resize-handle {
    position: absolute;
    right: -2px;
    top: 0;
    bottom: -2px;
    width: 4px;
    background-color: theme('colors.neutral.3');
    pointer-events: none;
}

.ProseMirror p {
    margin: 0;
}

.tableWrapper {
    padding: 1rem 0;
    overflow-x: auto;
}

.resize-cursor {
    cursor: ew-resize;
    cursor: col-resize;
}
</style>
