import React, { FC } from 'react'
import parse from 'html-react-parser'

interface LabelledTextProps {
    label: string;
    content: string;
    formatHtml?: boolean
}

export const LabelledText: FC<LabelledTextProps> = ({
    label,
    content,
    formatHtml = true
}) => (
    <>
        <h4 className='text-gray-400 mb-2 mt-6 text-xs font-light'>{label}</h4>
        {formatHtml ? (
            parse(content)
        ) : (
            <p>{content}</p>
        )}
    </>
)