# Start from the specified image
FROM fredblgr/ubuntu-novnc:20.04

# Explicitly set user as root
USER root

# Install gobuster
RUN apt update && \
    apt install -y gobuster && \
    apt clean && rm -rf /var/lib/apt/lists/*

# Copy any necessary files or configurations (if needed)
# For example:
# COPY ./path_on_host /path_in_container

# Expose any necessary ports (if needed)
# For example, if you need to expose port 6080:
EXPOSE 6080

# Set the default command to run when starting the container
CMD ["tail", "-f", "/dev/null"]
