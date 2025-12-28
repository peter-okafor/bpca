import React, { FC, useState } from "react";

export interface ImageProps extends React.ImgHTMLAttributes<HTMLImageElement> {
    fallbackSrc?: string;
}

export const Image:FC<ImageProps> = ({
    fallbackSrc,
    ...props
}) => {
    // const [selectedSrc, setSelectedSrc] = useState(props.src);

    return (
        <img onError={e => {
            if (fallbackSrc) {
                e.currentTarget.src = fallbackSrc
                fallbackSrc = ''
            }
        }} {...props} />
    )
}