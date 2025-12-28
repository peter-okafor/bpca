import { FC, HTMLAttributes } from "react";

export const WantToJoin: FC<HTMLAttributes<HTMLElement>> = ({
    className,
    ...props
}) => (
    <section
        className = {`bg-[#7B35C6] lg:mx-[14.5%] mb-[4.4rem] mt-6 rounded-md text-white`}
        {...props}
    >
        <div className={`lg:flex lg:flex-row lg:py-14 md:pb-10 pt-10 pb-36 lg:px-16 px-6 bg-bpca_transparent bg-no-repeat lg:bg-right-top md:bg-right-top bg-bottom lg:bg-contain md:bg-contain bg-[percentage:48%] bg-origin-border ${className}`}>
            <h2 className="lg:w-[27%] text-xl font-semibold lg:h-fit text-left align-top lg:mb-0 mb-8">
                Want your pest company to appear on pests.org?
            </h2>
            <p className="lg:w-[73%] lg:pl-8 lg:pr-32">Join the British Pest Control Association (BPCA) to be included in the list of amazing pest management companies operating in the UK. Membership includes your assessment and your company appearing on pests.org? Learn more </p>
        </div>
    </section>
)