// resources/js/utils/fileIcons.js
export const getFileIcon = (type) => {
    const iconMap = {
        pdf: 'file-pdf',
        doc: 'file-word',
        docx: 'file-word',
        ppt: 'file-powerpoint',
        pptx: 'file-powerpoint',
        xls: 'file-excel',
        xlsx: 'file-excel',
        zip: 'file-archive',
        mp4: 'file-video',
        mov: 'file-video',
        avi: 'file-video',
        jpg: 'file-image',
        jpeg: 'file-image',
        png: 'file-image',
        gif: 'file-image',
        txt: 'file-alt',
        default: 'file'
    };

    return iconMap[type.toLowerCase()] || iconMap.default;
};

export const getFileIconComponent = (type) => {
    const icons = {
        pdf: '📄',
        doc: '📝',
        docx: '📝',
        ppt: '📊',
        pptx: '📊',
        xls: '📈',
        xlsx: '📈',
        zip: '🗜️',
        mp4: '🎬',
        mov: '🎬',
        avi: '🎬',
        jpg: '🖼️',
        jpeg: '🖼️',
        png: '🖼️',
        gif: '🖼️',
        default: '📁'
    };

    return icons[type.toLowerCase()] || icons.default;
};
