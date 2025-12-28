import React from "react";

interface PoweredSection extends React.HTMLAttributes<HTMLDivElement> {
    imageUrl?: string;
}

export const PoweredSection: React.FC<PoweredSection> = ({
    imageUrl = "",
    ...props
}) => {
    return (
        <div
            className=""
            {...props}
        >
            <div className="">
                {/* <div className="text-sm">Accredited by the British Pest Control Association</div> */}
                <img
                    className="rounded-full w-32"
                    src={`${imageUrl}images/powered_by_bpca.png`}
                    alt="logo"
                />
            </div>
        </div>
    );
};

